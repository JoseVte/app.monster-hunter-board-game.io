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
| Gamification | `cjmellor/level-up` |
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

ESLint 9 with flat config in `eslint.config.js`. `.eslintrc.cjs` and `.eslintignore` no
longer exist and `--ext` is a no-op, the `files` patterns decide what is linted.

ESLint 10 is blocked by `eslint-plugin-import@2.32`, which still peers `eslint: ... || ^9`.

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

## Architecture notes

### Domain models

`Campaign` is the aggregate root. A campaign has members (`campaign_user` with a
`CampaignMembership` pivot and roles), `Hunter`s, `Day`s (each day is a hunt against a
`Monster` with a `MonsterDifficulty`), and downtime activities. Hunters own `Item`s,
`Weapon`s (grouped by `WeaponType`, with a `parent_id` crafting tree and `WeaponAttack`s)
and `Armor`s (with `ArmorSkill`s). Crafting requirements live in the `count_item_*` pivots.

`Hunter::canCraftWeapon()` and `canCraftArmor()` hold the crafting rules. `Hunter::getUser()`
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
2. **Model content** (monster names, item descriptions, and so on): JSON columns handled by
   `App\Models\Traits\HasTranslations`, which extends the Spatie trait. Its `toArray()`
   flattens translatable fields and translatable enum casts to the current locale before
   they reach Inertia, so the frontend always receives plain strings.
   `scopeSearchTranslate()` is the MySQL `JSON_EXTRACT` search helper (note: it will not
   work under the sqlite test connection).

Locale is resolved by `App\Http\Middleware\Localization`.

### Seeding

Seed data lives in `config/seeders/` as plain PHP arrays (`monsters.php`, `armors.php`,
`items.php`, `downtime-activities.php`, and one file per weapon type under
`config/seeders/weapons/`). Seeder classes read from config and put images on the public
disk. `LevelSeeder` creates the 50 level curve plus the achievement catalogue and is
called first in `DatabaseSeeder`.

### Gamification (level-up)

- `User` uses `GiveExperience` and `HasAchievements`. `User::booted()` bootstraps a new
  user with `addPoints(0)` and grants every achievement at its starting progress, and the
  `deleting` hook cleans up experience, history and achievement pivots.
- Custom achievement metadata (`type`, `type_count`, `has_progress`, `color`, `image`)
  is added by the local migration `..._create_achievements_table.php`, keyed by
  `App\Enum\AchievementType` (`level`, `monster`, `weapon`, `armor`).
- Events and listeners: `UserEquipmentCrafted` (dispatched in `CampaignHunterController`
  on craft), `UserMonsterHunted` (dispatched in `CampaignController` when a day is
  completed) and the package's `UserLevelledUp`. All wired in `EventServiceProvider`.
- `User::setAchievementProgress()` writes absolute progress on the pivot and fires
  `AchievementAwarded` at 100.
- Level, points and achievements are shared to every page through `HandleInertiaRequests`
  (`$page.props.level`, `$page.props.user.achievements`) and rendered by
  `resources/js/Pages/Profile/Level.vue`.

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
14 monsters and 18 achievements.

**`composer coverage` does not run locally.** pcov is not built for the Herd PHP 8.5 binary
and the project now requires 8.5, so there is no coverage driver to fall back on. The last
measurement, taken on 8.4 before the requirement moved, was 66 percent overall with the
controllers and listeners in the 90s.

### Known gaps and open issues

Verified against the code, not carried over from an earlier pass.

- **Kushala Daora weapons are the only seed data missing.** `KUSHALA EXPANSION` is an empty
  section comment in all 14 files under `config/seeders/weapons/`. Every other section, base
  game through Ancient Forest, Wildspire Waste, Kulu-Ya-Ku, Teostra and Nergigante, is
  filled. 250 weapons total. Grep for an empty section rather than counting entries.
- **`Barroth Shredder` and `Jagras Hacker` each name two different weapon types.** Harmless
  now that `WeaponsSeeder` scopes the parent lookup to `type_id`, but worth confirming it is
  intentional rather than a copy and paste.
- **Twelve level-up tables are dead schema**: the four `streak*` ones and the eight the
  package's v2 migrations added (tiers, multipliers, challenges). Nothing in `app/` or
  `resources/js/` reads or writes any of them. They ship with the package and have to be
  migrated for it to boot.
- **The Laravel application skeleton is still the pre-11 one.** `app/Http/Kernel.php`,
  `app/Console/Kernel.php`, `app/Exceptions/Handler.php` and the nine providers work fine on
  Laravel 13, but everything the framework documents now assumes `bootstrap/app.php`.
  Adopting it is its own piece of work.
- **ESLint stays on 9** and **`vue-gtag` on 2**, both on purpose. ESLint 10 needs
  `eslint-plugin-import` dropped, which costs the `import/order` rule. vue-gtag 3 peers
  `vue-router`, which was removed as unused.
- **Achievement progress counts equipment owned, not craft events.** Upgrading a weapon
  detaches its parent, so an upgrade replaces rather than adds. Making upgrades count needs
  a craft log; there is no table for one.
- Four merged branches remain locally: `feature/craft-armors`, `feature/craft-weapons`,
  `feature/equip-armors`, `feature/equip-weapons`. Safe to delete.
- Sqlite is used for tests while production is MySQL, so `scopeSearchTranslate`, which
  relies on MySQL JSON functions, cannot be covered by the Feature suite.

### Suggested next step

The Kushala Daora weapons are the last of the seed data, and adopting the Laravel 11+
application skeleton is the last structural leftover. Neither blocks anything.

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
