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
| Backend | Laravel 10.50 (EOL branch), PHP `^8.3`, `config.platform.php` pinned to 8.3.0 |
| Frontend | Vue 3 + Inertia 1.x + Vite 5, SSR build enabled |
| Styling | Tailwind 3 + Flowbite, Montserrat as the app font |
| Auth / scaffolding | Jetstream (teams) + Fortify + Socialstream (Google, Discord, GitHub) |
| Authorization | spatie/laravel-permission (roles) + policies |
| i18n | spatie/laravel-translatable (models), vue-i18n (front), JSON lang files |
| Gamification | `cjmellor/level-up` |
| Queue / infra | Horizon, Redis, MySQL 8, Meilisearch (Scout), Mailpit, MinIO via Sail |
| Testing | Pest 2 (Feature + Unit), Dusk for browser tests |
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
  and `vue-i18n:generate`. Run it after adding any new `__()` or `$t()` string.
- `composer coverage` produces an HTML report in `./reports`.

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

### Continuous integration

`.github/workflows/laravel.yml` runs the Pest suite, `sentry.yml` cuts a release on push to
`main`. Both pin every action to a commit SHA with the version in a trailing comment; keep
that style when bumping.

The workflow **must** stay on PHP 8.3 or newer. `config.platform.php` is pinned to 8.3.0, so
`composer install` happily succeeds on an older PHP (it simulates 8.3 when resolving) and
then every subsequent `php` call dies in `vendor/composer/platform_check.php` with
"Your Composer dependencies require a PHP version >= 8.3.0". The failure surfaces at
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

## Current state (as of the last review)

`main` is level with `origin/main`. The last commit is `203d5be wip: weapon seeders`.

There is a **large uncommitted but fully staged changeset** (176 files, roughly +5.1k/-2.7k)
sitting on top of `main`. It is not one feature, it is four things at once:

1. **Gamification feature** (the real feature work): `cjmellor/level-up`, achievements,
   experience, streak tables, the three events and listeners, `LevelSeeder`,
   `Profile/Level.vue`, the `profile.level` route, and `tests/Feature/Level/GetAchievementsTest.php`.
2. **Test suite migration to Pest** via `pestphp/pest-plugin-drift`. Every PHPUnit class in
   `tests/Feature` was rewritten as Pest functions. This is what most of the diff is.
3. **Dependency bumps**: PHP requirement `^8.2` to `^8.3`, `roave/security-advisories`,
   Vite plugin 1.x, Vue 3.4, Tailwind 3.4, `"type": "module"` in `package.json` plus the
   matching renames (`.eslintrc.cjs`, `postcss.config.cjs`, `vite.config.mjs`).
4. **Style sweep**: the formatter rule changes reformatted essentially every PHP file
   (`!$x` to `! $x`, Yoda conditions removed, and so on).

On top of that there is a **second, unstaged changeset**: the dependency security update
(`composer.json`, `composer.lock`, `package.json`, `package-lock.json` and one line of
`app/Actions/Socialstream/CreateUserFromProvider.php`). See "Dependency security update" below.

Verified locally:

- `vendor/bin/pest`: **82 pass, 8 skipped, 0 failures**, 213 assertions, about 5 seconds.
  The 8 skips are pre-existing and intentional (Jetstream API support disabled, Fortify
  registration disabled for some providers). A few tests are flagged "deprecated" because
  the local PHP is 8.5 while the dependency set targets 8.3. Run with
  `php -d error_reporting="E_ALL & ~E_DEPRECATED" vendor/bin/pest` for readable output,
  or use Sail (PHP 8.3).
- `npm run build` and `npm run lint`: both clean. The `app` chunk is 538 kB, over the 500 kB
  warning threshold.

### Dependency security update

Composer went from **58 advisories across 21 packages to 3 across 1**:

- `config.platform.php` is pinned to `8.3.0`. Without it, the local PHP 8.5 makes the tree
  unresolvable (inertia 0.6.x caps at 8.3) and the lock would not match what CI installs.
- `roave/security-advisories` was **removed**. It makes every `composer update` fail,
  because Laravel 10 carries advisories that are only fixed in 12.60/12.61 and Laravel 10
  is EOL. It cannot be re-added until the framework is upgraded.
- `laravel/framework` 10.41.0 to 10.50.3, all of Symfony to patched releases, plus roughly
  350 other packages moved within their existing constraints.
- `spatie/laravel-sitemap` `^6.3` to `^7.0`, which is what pulls `spatie/browsershot` from
  3.61 to 5.4 and clears its 6 advisories. `GenerateSitemapCommand` needed no changes.
- `joelbutcher/socialstream` `^4.1` to `^5.6`, which fixes CVE-2024-56329 (account takeover
  through social account linking). The only app-side break was `switchConnectedAccount()`,
  removed in v5; `CreateUserFromProvider` now calls `createsConnectedAccounts->create()`
  directly, matching the v5 stub.

The frontend went from **340 advisory paths (5 critical, 166 high) to 36 (0 critical,
1 high)**. `npm audit` groups by package instead of by path and reports the same residual
set as 5 entries:

- `node-sass` and `sass-loader` were **removed**. Both were unused (no `.scss` anywhere,
  `sass-loader` is webpack-only) and `node-sass@9` cannot compile on modern Node, so it
  would break the install.
- Upgraded within the existing ranges: axios 1.6.5 to 1.20.0, vue-i18n 9.9.0 to 9.14.5,
  vite 5.0.10 to 5.4.21, vue 3.4.15 to 3.5.42, and their transitive deps.
- The project was then **migrated from yarn to npm** (see "Package manager" above), so the
  final lockfile is `package-lock.json`. `npm audit` reports the same residual set.

### Known gaps and open issues

- **Laravel 10 is EOL and carries 3 unfixable advisories** (CRLF injection in the default
  email rule, temporary signed URL path confusion). They are only fixed in 12.60+/13.10+.
  Upgrading the framework is the only real remedy, and it is also what would let
  `roave/security-advisories` come back.
- **Vite 5 has 3 remaining dev-server advisories** (`server.fs.deny` bypasses, esbuild dev
  server CORS). They need Vite 6.4.3+, which means a major bump of `vite`,
  `laravel-vite-plugin`, `@vitejs/plugin-vue` and `vite-plugin-pwa` together. None of them
  affect production builds, only the local dev server.
- **Two dependencies are abandoned**: `joelbutcher/socialstream` and
  `protonemedia/inertiajs-events-laravel-dusk`.
- **Achievement progress never accumulates.** `UserMonsterHuntedListener` and
  `UserEquipmentCraftedListener` both compute `min((1 / $achievement->type_count) * 100, 100)`,
  a constant. Crafting a second weapon writes the same progress as the first, so
  `craft-weapon-10` is stuck at 10 percent forever. Only `UserLevelledUpListener` is correct
  because it divides the actual level by `type_count`. A real counter (crafted items owned,
  days completed) needs to replace the hardcoded `1`.
- **Weapon seed data is incomplete**, which is what `wip: weapon seeders` refers to. Each
  file in `config/seeders/weapons/` is organised by uppercase section comments
  (`// ANCIENT FOREST`, `// KULU YA KU EXPANSION`, and so on) and the unfinished ones are
  left as a bare comment with no weapons under it, so grep for an empty section rather than
  judging by entry count. Current state across the 14 types:
  - `KULU YA KU EXPANSION` and `KUSHALA EXPANSION` are empty in **all 14**. Never started.
  - Base game complete (4): `bow`, `dual-blades`, `great-sword`, `hammer`.
  - Missing `ANCIENT FOREST` only (3): `gunlance`, `hunting-horn`, `lance`.
  - Missing both `ANCIENT FOREST` and `WILDSPIRE WASTE` (7): `charge-blade`,
    `heavy-bowgun`, `insect-glaive`, `light-bowgun`, `longsword`, `switch-axe`,
    `sword-shield`. These only have their default weapon plus the Teostra/Nergigante trees.

  `config/seeders/monsters.php` by contrast is complete: 14 monsters covering all six
  `MonsterExpansion` cases, each with difficulty, parts and items.
- **The level-up streak tables are dead schema.** Four `streak*` migrations ship with the
  package but nothing in `app/` or `resources/js/` reads or writes them.
- **The `profile.level` route is an inline closure in `routes/web.php`**, inconsistent with
  every other route in the file. It should become a controller.
- **Translation files are out of sync**: 3 keys present in `en.json` and missing from
  `es.json` (including two new achievement descriptions), 13 keys in `es.json` with no
  English counterpart. Run `composer generate-translations`.
- **`.env.example` is stale and has a corrupted line.** Line 48 reads literally
  `ABLY_KEY=\n\nPUSHER_APP_ID=` with backslash-n as text instead of real newlines, so
  `ABLY_KEY` gets a junk value and `PUSHER_APP_ID` never exists as a key. On top of that it
  is missing 20 keys that `.env` has: `ADMIN_*`, `APP_LOCALE`, `DEBUGBAR_*`, `DISCORD_*`,
  `GITHUB_*`, `GOOGLE_ANALYTICS_KEY`, `GOOGLE_CLIENT_*`, `GOOGLE_RECAPTCHA_*`,
  `IGNITION_LOCAL_SITES_PATH`, `MEILISEARCH_*`, `PUSHER_APP_ID`,
  `VITE_GOOGLE_ANALYTICS_KEY`. Note the test suite does pass with this file, so it does not
  break CI, it only hurts a fresh clone.
- README badges still advertise PHP 8.2 and Laravel 10.
- Stale branches remain on the local repo: `feature/craft-armors`, `feature/craft-weapons`,
  `feature/equip-armors`, `feature/equip-weapons`. All merged, safe to delete.
- Four models return `'url' => 'TODO'` in their search result payloads
  (`WeaponType`, `WeaponAttack`, `DowntimeActivity`, `ArmorSkill`), so those search hits
  are not clickable.

### Suggested next step

The staged changeset is doing too much to land as one commit. Splitting it into
style sweep, then Pest migration, then dependency bumps, then the gamification feature
would make it reviewable and make a bisect useful later. Fix the progress accumulation
bug before shipping the gamification part.

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
