# CLAUDE.md

Guidance for working in this repository.

## What this project is

Web helper app for managing campaigns of the **Monster Hunter World: The Board Game**
(Steamforged). Users create campaigns, invite members, register hunters, track days
and hunts, manage items, craft and equip weapons and armors, and (work in progress)
earn experience, levels and achievements.

Production domain: `app.monster-hunter-board-game.io`. Repo: `JoseVte/app.monster-hunter-board-game.io`.

## Stack

| Layer | Choice |
|---|---|
| Backend | Laravel 13.30, PHP `^8.5`, `config.platform.php` pinned to 8.5.0 |
| Frontend | Vue 3 + Inertia 3.x + Vite 8, SSR build enabled |
| Styling | Tailwind 4 (CSS-first config) + Flowbite 4, Montserrat as the app font |
| Auth / scaffolding | Jetstream (teams) + Fortify + Socialite (Google, GitHub, Discord) |
| Authorization | spatie/laravel-permission (roles) + policies |
| i18n | spatie/laravel-translatable (models), vue-i18n (front), JSON lang files |
| Gamification | local, `app/Models/Traits/Has{Experience,Achievements}.php` |
| Queue / infra | Horizon, Redis, MySQL 8, Meilisearch (Scout), Mailpit, MinIO via Sail |
| Testing | Pest 5 (Feature + Unit), Dusk for browser tests |
| Monitoring | Sentry, Laravel Telescope, Debugbar |
| PWA | `vite-plugin-pwa`, generated `public/sw.js` and manifest |

## Local development

Sail is the documented stack (`./vendor/bin/sail up`), but the machine also has Laravel
Herd, so `php artisan ...`, `vendor/bin/pest` and `npx vite build` run directly on the host.

```shell
./vendor/bin/sail up -d      # full stack (MySQL, Redis, Meilisearch, Mailpit, MinIO)
npm run dev                  # Vite dev server
npm run build                # client build + SSR build + copy webmanifest
vendor/bin/pest              # test suite (sqlite :memory:, no MySQL needed)
composer pint                # Pint with ./pint.json, the only PHP formatter
npm run lint / npm run lint:fix   # ESLint over Vue and JS
```

Useful composer scripts:

- `composer generate-translations` runs `artisan localize es,en`, `translations:extract-vue`
  and `vue:translations`. Run it after adding any new `__()` or `$t()` string. It writes
  new keys into both `en.json` and `es.json`, leaving the Spanish value empty, so translate
  them rather than shipping English placeholders.
- `composer coverage` needs a coverage driver, which the Herd PHP 8.5 binary does not have.

### Package manager

**npm only.** The server dropped yarn for disk space reasons, so `yarn.lock` was deleted
and `package-lock.json` is now committed (it used to be gitignored). Do not reintroduce
yarn, and do not run `yarn install` here: the two lockfiles would drift apart.

npm enforces peer dependencies where yarn 1 ignored them. That surfaced one latent problem:
`@toast-ui/vue-editor` declared `peer vue@^2.5.0` and this is a Vue 3 app. It was never
imported, so it was removed rather than papered over with `--legacy-peer-deps`. If a future
dependency triggers the same error, check whether it is genuinely unused before reaching for
that flag. (The whole toast-ui family is gone now, see "Rich text" below.)

### Rich text

Campaign descriptions are **markdown**, stored raw in `campaigns.description`.

`WysiwygInput.vue` wraps `md-editor-v3`. It replaced `@toast-ui/editor`, whose last release
was 2022 and which pinned `dompurify: ^2.3.3`, a branch with roughly 15 unfixed XSS
advisories and no upgrade path. That swap is what took the frontend to zero
production-facing advisories; the three that remain are all Vite dev server issues.

**Rendering is a server concern.** `Campaign::getDescriptionParsedHtmlAttribute()` runs
CommonMark with `html_input: strip` and `allow_unsafe_links: false`, and
`Campaign/Show.vue` prints that with `v-html`. There is no client side sanitizer, and there
should not be one. `description_parsed` is the same thing through `strip_tags()` for list
views. `tests/Feature/Campaign/CampaignDescriptionTest.php` pins the behaviour.

The editor sets markdown-it's `html: false` so its preview shows what a reader will
actually get instead of rendering raw HTML the server will drop.

Two toast-ui features went away: coloured text and merged table cells, neither of which is
standard markdown. Colour was emitted as raw `<span style="color: ...">` inside the
markdown, so any description written before the swap keeps its words and loses the colour.

The editor chunk is 861 kB of JS and 70 kB of CSS, up from toast-ui's 456 plus 196. Nearly
all of it is CodeMirror. It is a dynamic import, so it only loads on the campaign create and
edit forms.

### Analytics

`resources/js/analytics.js` talks to `gtag.js` directly. **`vue-gtag` was removed**, not
upgraded past 3: its whole value is a Vue plugin wrapper and a `pageTracker` driven by
`vue-router`, and this app has no router, so all it ever did here was inject the script and
make two calls.

That is also why GA had been recording nothing. Both vue-gtag 2 and 3 default
`send_page_view` to `false` and leave the event to the router-driven tracker, so with no
router the only things reaching GA were the tag load and the `config` call. The local module
sends the view itself on Inertia's `navigate`, which covers the first visit as well.

**The title cannot be read when `navigate` fires.** Inertia writes the new `<title>` from a
`debounce(..., 1)` callback that is scheduled during render, so it lands after `navigate`
and after the page chunk has been fetched, and any fixed delay reports the previous page.
It also skips the write entirely when the new title equals the old one. The module therefore
waits for a mutation of the title element and falls back to a 2 second timeout, which only
elapses in the equal-title case, where the document already holds the right value.

Nothing is sent outside `import.meta.env.PROD` or without `VITE_GOOGLE_ANALYTICS_KEY`.

### Invitations

`invitations` is a **platform level** invitation, separate from the two that already
existed (`team_invitations` from Jetstream and `campaign_invitations`). Any signed in user
may hold up to `config('invitations.max_pending_per_user')` pending ones at a time, and
sending is rate limited by the `invitations` limiter in `RouteServiceProvider`.

**The table stores a hash of the token, never the token.** `CreateInvitation` returns the
raw one exactly once, for the email, and it cannot be recovered afterwards. Lookups hash the
incoming value, and resending revokes the row and issues a fresh one rather than reusing it,
so a link that has already been shared stops working.

The status is derived from the three timestamps rather than stored, so they cannot disagree,
and revoked wins over accepted. Anything not pending is treated as absent when a link is
opened, which keeps revoked, expired and already used links indistinguishable to a visitor.

`AcceptInvitation::markAccepted()` re-reads the row `lockForUpdate` inside the transaction
and re-checks it, so two near simultaneous acceptances of one link cannot both succeed no
matter which caller forgets to check. It also owns the `Registered` event, fired through
`DB::afterCommit` and only when the address is not already trusted, which is what keeps a
provider sign in from sending a pointless verification mail.

`profile.show` is **re-declared in `web.php` after Jetstream's own route** so
`App\Http\Controllers\ProfileController` wins. It exists only to add the invitations to
that page; putting them in `HandleInertiaRequests` would pay for the query everywhere.

**Registration is still open.** Hiding it behind a flag is the next phase, deliberately not
done in the same step so the platform is never closed without a way in.

### Social login

Plain `laravel/socialite` with the three `socialiteproviders/*` extensions, registered in
`EventServiceProvider`. `joelbutcher/socialstream` used to own this; it is abandoned,
produced an account takeover advisory, and capped at Laravel 12.

`App\Http\Controllers\Auth\SocialAuthController` owns the whole flow. The callback
branches on `auth()->check()`, so one route both registers and links, and it refuses to
link a provider account that already belongs to someone else. Linked accounts live in
`providers` (renamed from socialstream's `connected_accounts`) behind `User::providers()`.

Callback URLs are `/auth/{provider}/callback`, not socialstream's
`/oauth/{provider}/callback`. **The URLs registered with Google, GitHub and Discord have to
match.**

The `socialLogin` Inertia prop lists a provider only when its `client_id` is configured, so
a button can never point at a redirect that will fail. `tests/Feature/SocialLoginTest.php`
covers registration, sign in, linking, the takeover refusal and unlinking.

### Inertia

**Run `php artisan view:clear` after upgrading `inertia-laravel`.** Version 3 moved the
initial page payload from a `data-page` attribute on `<div id="app">` to a
`<script data-page="app" type="application/json">` element. A stale compiled Blade view
still emits the old shape, and the failure is silent: the page and assets load, `#app`
stays empty, and nothing reaches the console because `createInertiaApp` rejects rather than
throwing.

### Game icons

Seed data marks a game symbol as `:name_icon:`. `resources/js/icons.js` holds the whole map
and `replaceIcons` swaps them, exposed as a global mixin method and used through `v-html`.
The token pattern only captures `[a-z0-9_]`, so nothing from the data can reach the markup
as anything but a name.

It used to be a hand written chain of `replaceAll` inside `app.js`, which is why
`:dragon_icon:` appeared twice and why **water, ice, thunder and dragon all carried
`alt="Fire"`**, announcing the wrong element to a screen reader on the only page that
renders any of this.

**A token with no artwork falls back to a labelled badge, not the raw text.** The sentence
around it usually already says the word ("the Axe :switch_axe_axe_icon:"), so the badge
stands in for the symbol rather than repeating it, and the name goes in the tooltip.

**Line breaks in seed text are `<br>`, never `\n`.** The files are single quoted PHP, where
`\n` is a backslash and an n rather than a newline, and it reaches the database that way.
`gunlance.php` was the one file that got this wrong.

**Not every token ends in `_icon`.** The data also writes `:charged_blade_vial:`,
`:kinsect_icon_1:` and `:deviation_icon_high:`, so a pattern anchored on that suffix walks
past eleven of them. The match is `:([a-z0-9_]+):`.

What reaches a page has grown since `MonstersSeeder` started reading and seeding
`resistance`, `setup`, `mechanics` (with its `ability` and `parts`) and `rewards`, not just
`name`, `category` and `expansion`. Monster ability, mechanics and reward text now carries
its tokens all the way to the Monster Show page. Some of those tokens have real artwork or
a curated label; several still render through the auto-humanized fallback badge, which is
a plain but safe rendering, not a missing seed path. Fifteen tokens still sit only in weapon
type descriptions, which are stored but which no component displays.

**Five armour skills have no description in either language** (Maximum Might, Agitator,
Nergigante Hunger, Kushala Daora Flight, Handicraft) and each is attached to an armour, so
the gap is on screen. `SeedDataTest` holds the list so a sixth fails rather than joining
them quietly.

`tests/Feature/Seeders/IconTokenTest.php` pins all of it: every token the data uses is known,
every mapped icon has a file on disk, nothing is both drawn and pending, nothing is pending
that the data no longer mentions, and no token is written without its leading colon, which
had already happened once in `lance.php`.

### Monster wiki page

`Monster` gained real schema for what the seed data had always declared but
`MonstersSeeder` never read: `resistance_{fire,water,thunder,ice,dragon,paralysis,poison,
sleep,nitro,stun}` (nullable ints, null meaning the monster has no rating for it, not zero),
`setup` and `mechanics`, plus three child tables, `monster_difficulties` (one row per
Easy/Normal/Hard tier: stars, health, ability), `monster_parts` (the body-part break rows
under a tier, positional) and `monster_rewards` (the roll-1-to-12 table).

**`App\Models\MonsterDifficulty` and `App\Enum\MonsterDifficulty` are two different things
that share a name.** The enum (`EASY`, `NORMAL`, `HARD`, `ARENA_EASY`, `ARENA_NORMAL`,
`ARENA_HARD`) already existed and is what `Day::$difficulty` casts to, the difficulty a hunt
is played at. The model is the new one, a monster's own per-tier stats row, and its
`difficulty` column happens to be cast to that same enum. Nothing joins the two; a `Day`'s
difficulty and a `MonsterDifficulty` row are unrelated facts that happen to share a value.

**`mechanics` is not translatable the normal way.** It is a list of
`{title, description: [{title, description}]}` sections, every leaf already bilingual in the
seed data, and Spatie's trait only flattens a flat string per locale. `Monster::mechanics()`
is a custom `Attribute::make(get:, set:)` instead, walking the structure by hand and
resolving the current locale on read.

**`Monster::difficulties()` orders by a portable `CASE WHEN`, not `stars`.** Ordering by
`stars` alone only happens to work while no monster pairs an arena tier with a non-arena one
at the same rating; the enum has six cases (`EASY, NORMAL, HARD, ARENA_EASY, ARENA_NORMAL,
ARENA_HARD`) and the relation orders on that declared order via `orderByRaw`. MySQL's
`FIELD()` would have been the obvious tool here and was deliberately not used, since the test
suite runs on sqlite, which has no `FIELD()` function.

**A monster's own icon (`icon_path`/`icon_url`) is a separate thing from a body-part icon.**
The former is the emblem printed on the physical card (all 15 sourced from Kiranico, in
`resources/images/monsters/`), seeded the same way `WeaponType.image_path` already was, and
falls back to a generated initials avatar when the file is absent. The latter, which body
part (`head`/`back`/`claw`, ...) a break row refers to, now has one: seven original pictogram
icons (`Head`/`Back`/`Claw`/`Tail`/`Leg`/`Wing`/`Paw`Icon.vue`), generic anatomical shapes
rather than any specific illustration, used on `Show.vue`'s and `Card.vue`'s body-part rows
in place of the plain text label the humanized name used to be alone.

**`Wiki/Monster/Card.vue` is a third, separate thing again: a data-only recreation of the
physical card's layout**, on its own route (`wiki.monster.card`, linked from `Show.vue`),
not a modal: header, difficulty tier selector, star/health, resistances, the active tier's
ability and body parts, on a parchment frame distinct from the app's usual panel. It shows
`icon_url` (the same small emblem as everywhere else) a little larger than its usual
24-40px badge size, but deliberately not blown up further: that emblem is also cropped from
the physical card, and a hero-image-sized reproduction of it would trade one version of that
problem for another. An earlier pass tried to source a full-body portrait per monster from
physiology-card reference photos; that was reverted; a radial fade could hide the source
photos' own corner UI boxes well enough, but the illustration itself was still too close a
reproduction of Steamforged's board-game art even faded, so the card stays data-only.

### Weapon and monster icons

The 14 weapon type icons were raster PNGs, numbered rather than named
(`icon_weapon_01.png`...`icon_weapon_14.png`). They are now SVGs, traced with `potrace` plus
an ImageMagick posterize/mask preprocessing step, named after the weapon type they actually
are (`resources/images/weapon-types/great-sword.svg`, and so on), with the seed data's
`'image'` key updated to match. `WeaponsSeeder`'s upload used to hardcode the destination
extension to `.png` regardless of the source file, harmless while every source was a PNG and
silently wrong the moment one was not; it now preserves the real extension.

**A second, `currentColor` variant exists for one reason: an `<img src="...svg">` cannot be
recoloured with CSS.** It loads as an opaque external resource, which is why the crafting
tree's existing rarity tinting only ever worked on `WeaponsIcon.vue` (an inline `<svg>`
component using `stroke="currentColor"`). `resources/images/weapon-types/mono/*.svg` swaps
the traced icons' hardcoded grays for `currentColor` plus `fill-opacity` (still three tones,
now driven by one colour), and `WeaponTypeIcon.vue` inlines the right one via
`import.meta.glob(..., { query: '?raw' })` and `v-html`, keyed by parsing the slug out of
`weaponType.image_url`. The plain full-colour SVG is still what every non-tree `<img
:src="weaponType.image_url">` uses.

### Styling

Tailwind 4, configured **in CSS**. There is no `tailwind.config.js`: the theme lives in
`resources/css/app.css` under `@theme`, with `@plugin`, `@source` and
`@custom-variant dark (&:is(.dark *))`. Dark mode is still class driven, toggled by
`ButtonDark.vue`, which writes `localStorage['color-theme']` and dispatches a
`toggleDarkMode` event. Note the key does not exist until the first toggle, so read the
`dark` class on `<html>` if you need the current theme, not localStorage.

**`@apply` inside a component `<style>` block needs `@reference '<relative>/css/app.css'`
as the first line.** Tailwind 4 resolves `@apply` against the stylesheet being compiled, and
a Vue SFC style block is its own stylesheet, so without it the build fails with "Cannot
apply unknown utility class". Five components rely on this: `GlobalSearch`, `Form/Switch`,
`ListWeapons`, `ListWeaponTypes` and `Profile/Level`.

`autoprefixer` is gone, Tailwind 4 handles prefixing. PostCSS loads `@tailwindcss/postcss`.

### Linting

ESLint 10 with flat config in `eslint.config.js`. `.eslintrc.cjs` and `.eslintignore` no
longer exist and `--ext` is a no-op, the `files` patterns decide what is linted.

Import ordering comes from **`eslint-plugin-import-x`**, not `eslint-plugin-import`. The
original still peers `eslint: ... || ^9` and has no release that accepts 10, so it pinned
the whole toolchain. `import-x` is the maintained fork of it, accepts `^10`, and carries
the same rules under an `import-x/` prefix, so `import/order` became `import-x/order`
with no loss. Its two peers are optional and are not installed.

`@eslint/js` has to be an explicit devDependency. ESLint 9 pulled it in transitively and
the flat config imported it anyway; on 10 that resolves to `ERR_MODULE_NOT_FOUND`.

**ESLint 10 needs Node `^22.13`**, above the `>= 20.19` floor the other packages set. The
CI pins `node-version: '22'`, which resolves to the latest 22.x and satisfies it.

### Framework upgrade

The project runs **Laravel 13 on PHP 8.5** with zero advisories from both `composer audit`
and `npm audit`. `roave/security-advisories` is back in `require-dev` to keep it that way.

Getting here needed three coupled steps, because PHP 8.5 was gated on the framework:
Pest 2 depends on a paratest that caps at 8.4, Pest 3 needs collision 8, and collision 8
conflicts with any framework below 11. Composer reports that as an unrelated symfony/console
conflict, so do not trust its first explanation.

The **Laravel 11 application skeleton was deliberately not adopted**. It is optional when
upgrading, so `app/Http/Kernel.php`, `app/Console/Kernel.php`, `app/Exceptions/Handler.php`
and the nine providers still exist and still work. Adopting it is a separate piece of work.

Jetstream went 3 to 5 without republishing its Vue components. The v3 pages in
`resources/js/Pages/{Profile,Teams,API}` render fine against v5, which matters because
several of them carry local changes (the Campaign members UI is a fork of the Teams one).

### Continuous integration

`.github/workflows/laravel.yml` runs the Pest suite, `sentry.yml` cuts a release on push to
`main`. Both pin every action to a commit SHA with the version in a trailing comment; keep
that style when bumping.

The workflow **must** stay on PHP 8.5 or newer. `config.platform.php` is pinned to 8.5.0, so
`composer install` happily succeeds on an older PHP (it simulates 8.3 when resolving) and
then every subsequent `php` call dies in `vendor/composer/platform_check.php` with
"Your Composer dependencies require a PHP version >= 8.5.0". The failure surfaces at
`artisan key:generate`, nowhere near the real cause, so check the PHP version first.

The workflow does not set `DB_CONNECTION` or `DB_DATABASE`. PHPUnit's `<env>` entries do not
override variables that already exist in the environment, so setting them in the workflow
silently overrode the `sqlite :memory:` from `phpunit.xml` with a file database. Leave them
unset and let `phpunit.xml` decide.

`pest --parallel` is deliberately not used. The suite runs in about six seconds and
`TestCase::setUp()` seeds on every test, so parallelism buys nothing and adds risk.

The `frontend` job runs `npm ci`, `npm run lint` and `npm run build` on Node 22. It also
installs the composer packages (`--no-dev`), because `resources/js/app.js` imports Ziggy
from `vendor/tightenco/ziggy/dist/vue.m`, so the build fails with an unresolved import if
`vendor/` is absent. It needs no `.env`. Node 22 is the floor: `readdirp` and `sass` require
`>= 20.19`, and `glob`, `jackspeak` and `lru-cache` require `20 || >=22`.

### Deployment

`deploy.sh` holds the steps that run once the new code is on the server, so the deploy is
reviewed like any other change. The script in Forge only pulls, takes the lock and calls it;
the header comment carries the snippet it should contain.

**It exists because the Forge script still built with yarn.** The project moved to npm and
deleted `yarn.lock`, and Node 22 ships corepack, which already owns the `yarn` and `yarnpkg`
shims in the nvm bin directory, so `npm install -g yarn` fails with `EEXIST` and takes the
whole deploy with it. The failure is worse than it looks: everything before it (composer,
migrations, caches, FPM) has already succeeded, so the site ends up serving the new PHP
against the previous release's `public/build`, which after the Inertia 0.6 to 3 move means
an empty `#app` and nothing in the console.

Two steps are held behind environment flags rather than run every time:

- `RUN_SEEDERS=1` runs the eight content seeders by name. `db:seed` with no `--class` is
  never safe here, see "Seeding" above. They are idempotent, but renaming an entry in
  `database/seeders/data/` adds a row rather than renaming one, so it stays deliberate.
- Migrations run unconditionally. There is nothing like the gym-manager situation where the
  recorded names stopped matching the files.

**No `NODE_OPTIONS` heap cap**, unlike the gym-manager script. Vite 8 builds through
rolldown, which works in native code rather than in the V8 heap, so `--max-old-space-size`
governs the part that is not the problem. A measured run peaks around 850 MB resident for
the client and SSR bundles together.

The workbox cleanup is not cosmetic: vite only empties `public/build`, while `sw.js` and its
hashed workbox chunk are written to `public/` itself, so every build that changes the hash
leaves the previous chunk on disk forever. There were five of them when the script was
written, the oldest from July 2023.

## Architecture notes

### Domain models

`Campaign` is the aggregate root. A campaign has members (`campaign_user` with a
`CampaignMembership` pivot and roles), `Hunter`s, `Day`s (each day is a hunt against a
`Monster` with a `MonsterDifficulty`), and downtime activities. Hunters own `Item`s,
`Weapon`s (grouped by `WeaponType`, with a `parent_id` crafting tree and `WeaponAttack`s)
and `Armor`s (with `ArmorSkill`s). Crafting requirements live in the `count_item_*` pivots.

A weapon is made through a **`WeaponRecipe`**, which carries the monster line it belongs to
and what it costs. Most weapons have exactly one; `Twin Nails` and `Fire and Ice` in dual
blades have two, because either Teostra or Kushala Daora parts will build them, at different
prices. `weapons.branch` and `weapons.branch_id` are gone, that lives on the recipe now.

The data writes this as a list of branches and a matching list of material sets, **paired by
position**, and `SeedDataTest` refuses a weapon whose two lists disagree in length.

`Hunter::craftableRecipes()` answers which recipes a hunter can afford rather than a bare
yes, and `canCraftWeapon()` is that being non-empty. The player picks which parts to spend;
a choice they cannot afford is refused rather than quietly swapped for one they can.

**A line reachable from two monsters is listed under both**, so `create_weapon_tree()` can
put the same line under more than one key.

`Hunter::canCraftArmor()` holds the armour rule, which stays one recipe per armour. `Hunter::getUser()`
resolves the owning user, which is how gamification events reach a `User`.

### Enums

All enums live in `app/Enum` and most implement `App\Enum\Contracts\TranslatableEnum` via
the `App\Enum\Traits\TranslatableEnum` trait. That gives `label()`, `asSelectable()`,
`asKeyLabelObjectSelectable()` and `rule()`. Enums shared with the frontend are exposed as
Inertia shared props in `HandleInertiaRequests`, not fetched per page.

### Translations

Two separate mechanisms, do not confuse them:

1. **UI strings**: `__()` in PHP, `$t()` in Vue, stored in `resources/lang/{en,es}.json`
   and mirrored into `resources/js/vue-i18n-locales.generated.js` by the generate script.
   **Do not put a placeholder in a key a Vue file passes to `$t()`.** The generator rewrites
   `:name` to `{name}` in the key as well as the value, so `$t(':name did a thing')` looks up
   a key that no longer exists and the raw string is rendered. Lang files keep the `:name`
   form because PHP's `__()` needs it. Compose the dynamic part in the template instead,
   which is what every `$t()` call in the project does.
   Run `composer generate-translations`, not `php artisan vue:translations` on its own: the
   bare command writes to a path that does not exist and dies.
2. **Model content** (monster names, item descriptions, and so on): JSON columns handled by
   `App\Models\Traits\HasTranslations`, which extends the Spatie trait. Its `toArray()`
   flattens translatable fields and translatable enum casts to the current locale before
   they reach Inertia, so the frontend always receives plain strings.
   `scopeSearchTranslate()` is the MySQL `JSON_EXTRACT` search helper (note: it will not
   work under the sqlite test connection).

Locale is resolved by `App\Http\Middleware\Localization`.

### Seeding

Seed data lives in **`database/seeders/data/`** as plain PHP arrays (`monsters.php`,
`armors.php`, `items.php`, `downtime-activities.php`, and one file per weapon type under
`weapons/`), read through `Database\Seeders\SeedData`. Seeder classes put images on the
public disk. `LevelSeeder` creates the 50 level curve plus the achievement catalogue and is
called first in `DatabaseSeeder`.

**It used to live under `config/`**, which meant `config:cache` produced a 431 kB file that
every production request loaded and unserialised to serve seven calls that only ever run
from the console. The cache is 67 kB now. Do not move it back.

**Every data file keys its entries by the English name**, with `'name'` holding the Spanish
one. Weapons and items used to be lists of `['name' => ['en' => ..., 'es' => ...]]`; that was
about 1100 lines of pure repetition and it let a name be duplicated inside a single file.
Keeping the English name as the array key makes that impossible and matches what armours and
monsters already did.

**`php artisan db:seed` with no `--class` also runs `UserSeeder`, `CampaignSeeder` and
`HunterSeeder`**, which create demo data with factories, into whatever database is
configured. `HunterSeeder` will attach a made up hunter to a real campaign and repoint the
membership at it. Against a database you care about, call the content seeders by name:
`RolesSeeder`, `LevelSeeder`, `ItemsSeeder`, `MonstersSeeder`, `ArmorSkillsSeeder`,
`ArmorsSeeder`, `DowntimeActivitiesSeeder`, `WeaponsSeeder`.

**Renaming an entry creates a row rather than renaming one.** The seeders match on
`name->en`, so the old row survives as an orphan and has to be deleted by hand.

`tests/Feature/Seeders/SeedDataTest.php` walks roughly 1600 name references: weapon parents
and materials, the monster a weapon or armour branches from, armour materials and skills,
monster drops, plus uniqueness in both languages. Nothing else enforces them, and a typo
otherwise surfaces as a seeder blowing up somewhere unhelpful, or worse, silently binding to
the wrong row. Run it after editing any data file.

Weapon and armour **attack names are deliberately not validated**: there are 321 distinct
ones and 129 appear exactly once, so there is no canonical list to check against.

### Crafting

Achievement progress is counted from a **`crafts`** log, one row per act of crafting, not
from the equipment a hunter holds. Crafting an upgrade detaches the weapon it was made from,
so counting what is owned left the number flat however much a player crafted, and nothing
covered that path. The migration backfills the log from what everyone already owns, so no
account loses progress; it undercounts parents that were already replaced, but it never
takes anything away.

### Gamification

**`cjmellor/level-up` was removed**, not upgraded. The app used seven of its methods, three
of its models and two of its events, while twelve of its seventeen tables were dead schema
that had to be migrated for the package to boot. The v3 line adds leagues, leaderboards and
typed multiplier scopes, so the gap was widening rather than closing. What replaced it is
about a hundred and fifty lines under `app/`, and four tables remain: `levels`,
`experiences`, `achievements` and `achievement_user`.

- `User` uses `App\Models\Traits\HasExperience` and `App\Models\Traits\HasAchievements`.
  `User::booted()` bootstraps a new user with `addPoints(0)` and grants every achievement at
  its starting progress; the `deleting` hook clears experience and the achievement pivots.
- **The level someone holds is derived, never stored as a number.** `levels` records what
  each level costs (`next_level_experience`), level one costs nothing and stores `null`, so
  the current level is the dearest row a point total can afford. `addPoints()` recomputes it
  and `levelUp()` fires one `UserLevelledUp` per level gained, which is what advances the
  level achievements.
- `nextLevelAt()` answers in points by default and as a percentage with its second argument.
  Both return `0` for a user with no `experiences` row, which is the state of any account
  created before gamification existed.
- Custom achievement metadata (`type`, `type_count`, `has_progress`, `color`, `image`)
  is added by the local migration `..._create_achievements_table.php`, keyed by
  `App\Enum\AchievementType` (`level`, `monster`, `weapon`, `armor`).
- Events: `UserEquipmentCrafted` (dispatched in `CampaignHunterController` on craft),
  `UserMonsterHunted` (dispatched in `CampaignController` when a day is completed),
  `UserLevelledUp` and `AchievementAwarded`, all now in `app/Events`. Their listeners live in
  `app/Listeners` and are auto-discovered.
- `User::setAchievementProgress()` writes absolute progress on the pivot and fires
  `AchievementAwarded` at 100.
- Level, points and achievements are shared to every page through `HandleInertiaRequests`
  (`$page.props.level`, `$page.props['user.achievements']`, which reads
  `achievementsWithProgress`) and rendered by `resources/js/Pages/Profile/Level.vue`.
- Experience per monster now comes from `config/gamification.php`, not the package config.
- `tests/Feature/Level/ExperienceTest.php` was written against the package and kept passing
  against the replacement without a single assertion changing. Treat it as the contract.

## Conventions

- Follow the Spatie PHP and Laravel guidelines (there is a `php-guidelines-from-spatie`
  skill; the user's global instructions require it for Laravel work).
- Code style is **Pint only** (`pint.json`, Laravel preset plus `@PHP83Migration`). The
  distinctive rules: imports ordered class then function then const and sorted **by
  length**, `void_return`, arrow functions, `fully_qualified_strict_types`,
  `! $x` rather than `!$x`, no Yoda conditions. Run `composer pint` before committing.
  `vendor/bin/pint --test` must come back clean; CI enforces it.

  php-cs-fixer used to run alongside Pint over the same files with the Symfony preset
  instead of the Laravel one. Every explicit rule in `.php-cs-fixer.php` was already in
  `pint.json`, so the presets were the only difference, and the two tools undid each
  other's work. Do not reintroduce it.
- Tests are Pest style: `test('...', function () {...})` with `expect()` chains, not
  PHPUnit classes. `tests/Pest.php` binds `Tests\TestCase` and `RefreshDatabase` to the
  whole `Feature` suite. `TestCase::setUp()` auto seeds `RolesSeeder` and `LevelSeeder`,
  so tests can assume roles and the achievement catalogue exist.
- Controllers are thin and return Inertia responses or `back(303)`. Form validation lives
  in `app/Http/Requests`. Authorization lives in policies (`CampaignPolicy`, `HunterPolicy`).
- Frontend pages mirror the backend: `resources/js/Pages/<Domain>/...` with a `Partials/`
  folder for page-specific components and `resources/js/Components` for shared ones.
- `app/Console/Commands/MakeController.php` is a custom generator, prefer it for new controllers.

## Current state

The whole upgrade arc is done and sits on a chain of unpushed branches on top of `main`,
roughly 37 commits. `main` itself is still the old `203d5be wip: weapon seeders`.

The branches stack in order and each one was verified before the next started:

```
chore/php-85 -> chore/i18n-and-social -> chore/tidy-up
```

Where the project landed:

| | Was | Now |
|---|---|---|
| Framework | Laravel 10.41 | Laravel 13.30 |
| PHP | `^8.2` | `^8.5` |
| Inertia | 0.6 | 3.x |
| Tailwind | 3.4 | 4 |
| Vite | 5 | 8 |
| Pest | 2 | 5 |
| Social login | socialstream (abandoned) | Socialite |
| `composer audit` | 58 advisories / 21 packages | none |
| `npm audit` | 340 paths, 5 critical | none |
| Tests | 82 pass, 8 skipped | 137 pass, 4 skipped |

Verified on every step: the full CI job in a clean checkout, the seeders against a scratch
sqlite database, and the app driven in a real browser. The seeders produce 250 weapons,
15 monsters and 18 achievements.

**`composer coverage` does not run locally.** pcov is not built for the Herd PHP 8.5 binary
and the project now requires 8.5, so there is no coverage driver to fall back on. The last
measurement, taken on 8.4 before the requirement moved, was 66 percent overall with the
controllers and listeners in the 90s.

### Known gaps and open issues

Verified against the code, not carried over from an earlier pass.

- Google Analytics no longer goes through a package, see "Analytics" above.
- **`Wiki/Weapon/Detail.vue` renders which attack cards an upgrade adds and removes, but not
  elemental or status attacks.** The seed data has no field for either yet, so this is a
  schema and data-entry gap, not a template fix: nothing to load until that is added.
- Sqlite is used for tests while production is MySQL, so `scopeSearchTranslate`, which
  relies on MySQL JSON functions, cannot be covered by the Feature suite.

### Suggested next step

No single gap dominates the way the `expansion` column used to (that one is done: it lives
on `weapon_recipes` and `armors`, seeded, filterable from the wiki, and the wiki's Monster,
Weapon and Armor detail pages all cross-link their monster, expansion, rarity and material
items to the matching filtered list or item page). Armour resistance icons are wired in too
(`Resistance.vue`, used by `ArmorDefenseRow.vue` on both `Wiki/Armor/Index.vue` and
`Wiki/Armor/Detail.vue`), every item has its own icon (`Item::icon_path`/`icon_url`,
the same pattern as `Monster` and `WeaponType`), a monster's body-part rows have their own
original icon per part (see "Monster wiki page" above), and the monster's own "paper card"
recreation view is built (`Wiki/Monster/Card.vue`, linked from `Show.vue`), data-only rather
than carrying a portrait image. What is left is a set of independent, smaller items:

1. `Wiki/Weapon/Detail.vue`'s elemental/status attack display, which needs new schema
   (nothing in the seed data carries it yet) and per-weapon data entry, not just a
   template change.

Before deploying: **production has to be on PHP 8.5** (`require.php` is `^8.5`, so an older
binary dies in `vendor/composer/platform_check.php`), and **the OAuth callback URLs
registered with Google, GitHub and Discord have to move** to `/auth/{provider}/callback`.

## Things to be careful about

- Do not hand edit `resources/js/vue-i18n-locales.generated.js`, it is generated.
- `_ide_helper.php` (890 kB) and `_ide_helper_models.php` are generated and gitignored,
  but they are present on disk, so exclude them from greps or they will dominate results.
  The same applies to `.phpunit.result.cache`.
- `public/vendor/horizon/*` is vendor published output, not hand written.
- `public/build/`, `public/sw.js` and `public/workbox-*.js` are build artifacts and are
  gitignored, so running `npm run build` will not dirty the tree.
- Sqlite is used for tests while production is MySQL, so anything relying on MySQL JSON
  functions (`scopeSearchTranslate`) cannot be covered by the Feature suite as it stands.
