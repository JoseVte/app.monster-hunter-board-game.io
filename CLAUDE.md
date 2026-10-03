# CLAUDE.md

Guidance for working in this repository.

## What this project is

Web helper app for managing campaigns of the **Monster Hunter World: The Board Game**
(Steamforged). Users create campaigns, invite members, register hunters, track days
and hunts, manage items, craft and equip weapons and armors, and (work in progress)
earn experience, levels and achievements.

Production domain: **`mh-board-game.josrom.io`**, which is what `APP_URL` holds on the
server. It is not `app.monster-hunter-board-game.io`, which this file claimed for a long
time and which does not resolve; that name is the repository's, not the site's. The OAuth
callbacks derive from `APP_URL`, so they are already right.

Repo: `JoseVte/app.monster-hunter-board-game.io`.

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

**The editor fetches nothing from a third party, and that has to be kept.** Out of the box
`md-editor-v3` loads eight assets from `unpkg.com` every time it mounts (highlight.js, KaTeX,
Mermaid, ECharts and Prettier, two CSS and six JS, Mermaid and ECharts a megabyte or more
each), which handed every visitor's address to that CDN on the two campaign forms. The
`no-katex`, `no-mermaid`, `no-highlight`, `no-echarts` and `no-prettier` props turn all of it
off. That loses nothing a reader would see: the server renders descriptions with plain
CommonMark, which draws none of those, so the preview was showing formulas and coloured code
no reader ever got, the same dishonesty `html: false` already fixes for raw HTML. Cropper is
off through `no-upload-img`, and screenfull is only fetched by the `fullscreen` toolbar
button, which is not in the toolbar. `resources/js/__tests__/wysiwygInput.test.ts` mounts the
real editor and fails on any remote `<link>` or `<script>`; with the props removed it lists
all eight.

### Cookies and tracking

**The app sets no cookie that needs consent, and there is no cookie banner.** That is a
property worth keeping, because it is the only reason there is nothing to maintain here.

What a visitor ends up with: the Laravel session cookie, `XSRF-TOKEN`, `remember_web_*`
(only if they tick the box themselves) and `_GRECAPTCHA` on the login and register pages.
All four are exempt from consent as strictly necessary, functional-on-request, or security.
The light/dark theme is `localStorage['color-theme']`, not a cookie at all.

**Google Analytics was removed**, along with `resources/js/analytics.js` and the
`GOOGLE_ANALYTICS_KEY` pair. It was loaded from `app.js` at module scope, before Inertia
even mounted, so `_ga` and `_ga_<ID>` were set on every page with no consent asked and none
possible. It had also recorded nothing for years, because both vue-gtag 2 and 3 default
`send_page_view` to false and leave the event to a `vue-router` tracker this app has no
router for, so there was no history to lose. If analytics comes back, the cheap option is
something cookieless (Plausible, Umami); anything that sets `_ga` brings the banner, the
Consent Mode wiring and the maintenance back with it.

**`spatie/laravel-cookie-consent` was removed** rather than fixed. Its banner had an accept
button and nothing else, no reject, no link to the policy, and its cookie lasted twenty
years. More to the point it gated nothing: no script anywhere was conditional on it, so the
consent was decorative. With no non-exempt cookies left there is nothing for it to ask
about.

**reCAPTCHA loads only where it is verified.** `resources/js/recaptcha.ts` calls
`recaptcha-v3`'s `load()` from the login and register components. It used to be the
`vue-recaptcha-v3` plugin installed on the app in `app.js`, and that plugin's `install()`
loads Google's script immediately, so the wiki and the public page carried it too. A cookie
set for anti-fraud is only arguably exempt while it stays on the pages that need it. The
badge is shown on those two pages and hidden on unmount, which is not decoration: Google
requires either the badge or visible attribution wherever it runs.

Sentry is backend only, with `send_default_pii` false, no tracing, no profiling and no
session replay, so it sets nothing in the browser. Debugbar and Ignition are `require-dev`,
so `composer install --no-dev` leaves them out of production entirely; the
`PHPDEBUGBAR_STACK_DATA` and randomly-named cookies you see locally come from Debugbar and
cannot exist on the server.

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

**`config/inertia.php` exists for one line.** The package default points
`pages.paths` at `resource_path('js/pages')`, lowercase, which is what the newer Laravel
starter kits use; this project keeps `resources/js/Pages`, which is also what `app.ts` and
`ssr.ts` glob. Nothing breaks at runtime, since `pages.ensure_pages_exist` is false and the
frontend resolves a component against the Vite bundle rather than the filesystem. It is
`assertInertia` that pays: `testing.ensure_pages_exist` is true, so it looks the file up on
disk, a case-insensitive filesystem answers for the wrong case, and the result is a suite
that passes on macOS and fails seventeen times on the Linux CI runner with "Inertia page
component file [...] does not exist". The whole `pages` key has to be written out, because
the provider merges with `mergeConfigFrom`, which only merges the top level.

`tests/Feature/InertiaPagePathTest.php` pins it, comparing against `scandir` rather than
`is_dir` so that it fails on macOS too. `is_dir` would answer yes to the wrong case on the
machine where the mistake is most likely to be made, so it would pin nothing.

### Generated frontend types

`composer generate-types` runs `artisan typescript:transform`, which walks every model
under `app/` through `App\Support\TypeScript\ModelShape` and `ModelTransformer` and writes
`resources/js/types/generated.d.ts`, then `artisan ziggy:generate --types-only` writes
`resources/js/types/ziggy.d.ts` beside it. Both files are committed rather than built on
demand, because the conversion of the remaining `.vue` files to TypeScript needs them on
disk to typecheck against, not produced by a step a contributor might forget. The transform
needs a migrated database, since `Schema::getColumns()` reads the real table rather than a
model's own casts alone, so it cannot run from a bare checkout.
`tests/Feature/TypeScript/GeneratedTypesAreCurrentTest.php` fails the suite when the
committed file and a fresh `ModelShape::for()` call disagree on a model's property names,
which turns a forgotten `composer generate-types` into a red test rather than a type that
quietly stopped matching the database.

`ModelShape` exists at all because of two things `HasTranslations::toArray()` does that a
plain reading of the schema would miss. A translatable column such as `Monster.name` is a
JSON blob in the database and a plain string by the time Inertia sees it, since `toArray()`
flattens it to the current locale on the way out; and a column cast to a `TranslatableEnum`
arrives as that enum's translated label, a string, never the enum's own backing value. A
generator that read the schema and the casts alone would tell every `.vue` file that these
columns are the raw JSON or the enum type, wrong in a way that would not fail until runtime.

A relation only reaches the frontend when the controller eager loaded it, so every relation
`ModelShape` describes, and the `_count` key beside it, is optional. The alternative would
claim a relation is always present, which is the exact shape of bug these types exist to
catch. A `MorphTo` relation is skipped entirely rather than guessed at, because describing
one calls the relation method on an unsaved model, and with the morph type column unset that
falls through to `morphEagerTo()` and builds the relation off the parent's own query:
`Craft::craftable()` would describe itself as `Craft`. Leaving the key undeclared makes
reading it a compile error instead of a silent lie.

An appended accessor with no matching `@typescript` tag fails generation by name, on
purpose. `unknown` is not a type error, so an accessor left at `unknown` would typecheck
against whatever a component does with it, the one outcome this generator is built to
refuse: a type that is wrong is worse than no type at all. The tag itself is deliberately
not `@property`. `@property` is PHPDoc read by PhpStorm, by `php artisan
ide-helper:models`, and by any static analyser, and the value on its right here is
TypeScript, not PHP: writing `@property App.Enum.InvitationStatus $status` tells all three
that the model has a real property of a PHP class that does not exist. `@typescript` is a
tag nothing else in the toolchain reads, so it can carry a TypeScript type without lying to
the rest of it. Nine models carry one today: `Invitation`, `Monster`, `Campaign`,
`WeaponRecipe`, `Weapon`, `User`, `Item`, `Armor` and `WeaponType`.

Two classes never appear under `app/`, so the transformer's own
`transformDirectories(app_path())` would never emit a type for them on its own:
`Spatie\Permission\Models\Role` and `...\Permission`, the two that `CampaignMembership::role()`,
`CampaignInvitation::role()`, and `User::roles()` and `permissions()` relate to.
`resources/js/types/vendor-models.d.ts` declares `App.Models.Role` and `App.Models.Permission`
by hand, and `ModelShape::VENDOR_MODELS` is the allow-list that keeps the file honest: a
relation to any other class outside `App\Models` fails generation, naming the model, the
relation and the class, rather than quietly naming a type nobody wrote and letting
`skipLibCheck` hide the result as `any`.

Not every relation gets that treatment. `ModelShape::relations()` only considers a method
with a declared `ReflectionNamedType` return, and Jetstream's `Team::users()`,
`Team::owner()` and `HasTeams::teams()` have none, so `App.Models.Team` has no `users` or
`owner`, and `App.Models.User` has no `teams`, `current_team` or `owned_teams`. That gap is
real rather than theoretical: Jetstream's own `ShareInertiaData` puts `current_team` and
`all_teams` on `auth.user` on every request. Whoever writes the hand rolled `inertia.d.ts`
for the shared Inertia props next will need to declare those two by hand, the same way
`vendor-models.d.ts` declares `Role` and `Permission`, because `ModelShape` cannot reach
into a vendor parent it does not control to add the annotation itself.

Two places in the implementation are narrower than the description above makes them sound,
and a future reader should not be misled by either. The `@typescript` tag overrides a
column's type and supplies an appended accessor's, but the relations loop that runs after
both never consults it: a tag named after an actual relation method would be silently
overwritten by whatever `ModelShape` derives for that relation, not an error and not a
warning. And `GeneratedTypesAreCurrentTest` compares the committed file against
`ModelShape`'s own output, which catches a model that drifted from what the generator would
produce for it now, but it can never catch the generator's own view of a model diverging
from what Inertia actually serialises, since both sides of that comparison come from the
same code.

### The TypeScript conversion

A snapshot, taken 29 September 2026, not a permanent claim: 38 of the 165 `.vue` files under
`resources/js` carry `lang="ts"`. The entry points, the five pure modules, the three
infrastructure modules, the shared props and route names, and the Wiki are typed: 16 files
under `Pages/Wiki` plus 20 shared components with a `<script>` block, the ones the Wiki
reaches into. (29 was the count of shared components the Wiki *imports*, not the count that
carry `lang="ts"`; the two numbers measure different things and should not be read as the
same claim.) Hunter, Campaign, Profile,
Teams, API and the rest of the shared library are not, and copying the nearest neighbour for
a new component in one of those trees still produces JavaScript today. `tests/Feature/
FrontendRatchetTest.php` is what stops that count from drifting upward by accident; see below.

**The `defineProps` optionality trap is the one a converter cannot do without.** The runtime
form, `defineProps({x: Object})`, declares an optional prop; the type form, `defineProps<{x:
Foo}>()`, declares a required one. A mechanical conversion that copies the key names across
without adding `?` tightens every prop silently, and the typechecker will not say a word,
because the resulting type is simply stricter than the one it replaced, not wrong on its
face. This caught `Table/Cell.vue`: `Wiki/Item/Index.vue` always passes a `url`, but
`Wiki/Monster/Show.vue` uses the component bare, with no `url` at all, and only reading every
caller (not just the nearest one) surfaces that. The prop is `url?: string` now.

**The subtlest thing on the branch, and the one most likely to be undone by someone who has
not hit the symptom it fixes:** an ambient augmentation of a Vue component's instance
properties has to target `@vue/runtime-core`, never `vue`. `vue`'s own package re-exports
`@vue/runtime-dom`, which itself re-exports and augments `@vue/runtime-core`, and that is the
module an SFC's component instance type is actually built from with this Vue and vue-tsc
version. `declare module 'vue' { interface ComponentCustomProperties {...} }` compiles
without complaint and is inert: `$t`, `route`, `replaceIcons` and `getRarityColor` all come
back "property does not exist" inside a `<template>`, though script code calling
`this.route(...)` sees them fine. It cost a task's worth of template rewrites, chasing what
looked like a missing property on each one individually, before the module being augmented
turned out to be the actual fault. `resources/js/types/inertia.d.ts` augments
`@vue/runtime-core` for `replaceIcons`, `getRarityColor` and `route`, and separately for
`$t`, because `vue-i18n`'s own declaration file augments `'vue'`, the wrong module by this
project's own finding, so `$t` has to be redeclared locally against `ComposerTranslation`
rather than trusted to the package that owns it.

The three hand written declaration files under `resources/js/types/` exist because nothing
generates their contents. `inertia.d.ts` describes `HandleInertiaRequests::share()`, a PHP
array literal with no class and no columns behind it, so there is nothing for a reflection
based generator to walk. `ziggy-global.d.ts` exists because the generated `ziggy.d.ts`
declares an augmentation of a module, `ziggy-js`, that nothing in this program ever imports;
without a bare `declare module 'ziggy-js';` to create that module first, the augmentation has
nowhere to attach and every route name typo resolves to an unresolvable type that accepts
anything. The same file also declares the bare `Ziggy` global Blade's `@routes` directive
injects, which `ZiggyVue`'s `install()` reads directly and which has no import path of its
own to declare against. `vendor-models.d.ts` exists because `Role` and `Permission`
(`spatie/laravel-permission`) are the two models this app relates to that live outside
`app/`, so `composer generate-types`, which only walks `app_path()`, never sees them;
`ModelShape::VENDOR_MODELS` is the allow list that keeps a third one from going quietly
undeclared instead of failing generation by name.

**A misspelt route name is a compile error. A misspelt prop key is not, and the two should
not be assumed to behave alike.** `ziggy-global.d.ts` narrows `route()`'s name argument to
`keyof RouteList`, so a typo there fails `npm run typecheck`. `@inertiajs/core`'s own
`PageProps` is `{ [key: string]: unknown }`, an index signature, and merging `SharedProps`
into it in `inertia.d.ts` adds the declared keys on top without removing that signature, so
`page.props.canRegisterXYZ` still compiles, typed `unknown`, and only fails later if it lands
somewhere that rejects `unknown`.

**A runtime membership guard uses `Object.hasOwn`, never `in`.** `in` walks the prototype
chain, so `'toString' in someRecord` is `true`, and a type predicate built on `in` would say
yes to a key that was never in the data. `SongNotes.vue`, `WeaponStats.vue`,
`Wiki/Item/Show.vue`, `Wiki/Armor/Detail.vue`, `Wiki/Monster/Show.vue` and
`Wiki/Monster/Partials/MonsterPartBox.vue` all narrow an icon or attack lookup key this way. A
predicate reads as proof to everything downstream of it, which is exactly why a predicate
that can lie is worse than the plain cast it replaced.

**Never narrow a JSON column at a module or prop boundary.** A translatable column or a
translated enum reaches Inertia as a plain string, already resolved by `HasTranslations::
toArray()`, and the generated type says so; there is nothing left to narrow. Where a
controller trims the columns it sends, the page declares a `Pick` of the real model rather
than inventing a smaller one: `Wiki/Monster/Index.vue`'s `monsters` prop is `Array<Pick<
App.Models.Monster, 'id' | 'name' | 'category' | 'expansion' | 'icon_path' | 'icon_url'>>`,
matching `MonsterController::index()`'s own `select(['id', 'name', 'category', 'expansion',
'icon_path'])` field for field. A `Pick` that leaves every field's own declared type alone is
safe, because it is still describing a genuine subset of the same model; a `Pick` that goes
on to override one of those fields' types stops describing a subset and starts describing an
incompatible sibling, rejecting every caller that still holds the real model.

The ratchet holds two numbers, both re-measured rather than carried over from an earlier
task: of 165 `.vue` files, 144 contain a `<script>` block (the other 21 are template only SVG
icons, which can never carry `lang="ts"` and are excluded rather than left in the ceiling to
weaken it), and of those 144, 106 lack `lang="ts"`. `FrontendRatchetTest` asserts all three
counts, not just the last, because a file walk that silently matched nothing would make the
ceiling trivially true, which is the exact shape of green this repository has already shipped
twice. Converting a component is not finished until the ceiling in that test is lowered to
match; a conversion that leaves 106 in place fails the test on purpose.

The controller composed props Task 8 catalogued are the known gap in what the generator
covers: the weapon tree (`WeaponTreeEntry[]`), `craftable_recipes`, `missing_by_recipe`,
`matching`, `options` and `filters`. None of them describes a model or a relation, so nothing
walks a schema to produce them; each is declared locally, by hand, on every page that receives
one, and the same shape is duplicated across several pages rather than shared. Giving them a
real source of truth is its own piece of work, not attempted here.

The four snapshots in `resources/js/__tests__/__snapshots__/smoke.test.ts.snap` are the before
picture, written against plain JavaScript before any conversion touched the pages they cover.
A conversion that changes one is a bug in that conversion, to be investigated and fixed in the
component, not a snapshot to regenerate to match the new output.

Three gaps in `ModelShape`, the type generator, are worth knowing before converting any of
the remaining 106. A `MorphTo` relation is skipped outright, because describing one calls the
relation method on an unsaved model, and with the morph type column unset that falls through
to `morphEagerTo()` and describes the relation as the parent's own class. Jetstream's relation
methods (`Team::users()`, `Team::owner()`, `HasTeams::teams()`) declare no return type, so
`ModelShape` skips them too: `App.Models.User` has no `teams`, `current_team` or
`owned_teams`, even though `ShareInertiaData` puts `current_team` and `all_teams` on
`auth.user` on every request, a gap whoever converts the Layouts, Teams or Profile pages will
meet first. And a `withPivot()` relation's pivot payload is never attached to the related
model's type, even though the `App.Models.Pivot.*` shapes it could draw on already exist;
three relations deliver a `pivot.number` today (`WeaponRecipe::items()`,
`Weapon::attacksToAdd()`, `Weapon::attacksToRemove()`), each typed by hand at the point of use
as `App.Models.Item & {pivot: {number: number}}` or its `WeaponAttack` equivalent.

**Five more gaps, found by checking generated types against real serialised payloads rather
than by reasoning about the generator, all in the safe direction (a type wider or more
optional than the runtime, never a lie) and none of them this branch's to fix.** Every
`$appends` accessor is emitted optional (`ModelShape.php:140`), but `Model::attributesToArray()`
serialises every `$appends` entry on every `toArray()`, including behind a `select()`, so
`Monster.icon_url`, `Item.icon_url`, `WeaponType.image_url`, `Armor.type_value`,
`Armor.expansion_value`, `WeaponRecipe.expansion_label` and `Weapon.deviation_key` are all
optional in the types and always present at runtime; the relation branch's own docblock
(directly above `relations()`) carries a written justification for its optionality, and that
reasoning does not transfer to an append, which has no equivalent comment. `Monster.mechanics`
is typed `| null` and can never be null: the custom `Attribute` returns `[]` for a null
column, and 11 of the 15 seeded monsters prove it; the cause is a generator collision,
`ModelShape.php:115` takes the `@typescript` docblock type and `:124-126` then appends
`| null` from the column's own schema nullability, which the `Attribute` has already
absorbed, so any future `@typescript` docblock on a nullable column inherits the same false
optional. The nine `App.Models.Pivot.*` types all require an `id` that `withPivot()` never
hydrates; no page uses one of them today, and the two comments explaining why are the only
thing stopping the next one from trusting a field that is never there. `hunters` is declared
optional on both craft pages, and both controllers always send it, as `[]` for a guest.
`WeaponController.php:68` eager-loads `recipes.monster`, and `Weapon/Detail.vue` never reads
it: a wasted join and payload, backend work rather than a type to fix.

### Server side rendering

**SSR did not work at all until 2 October 2026, and nothing said so.** Three faults, each
enough on its own, all masked by `throw_on_error: false`, which turns a failed server render
into a silent fallback to client rendering with nothing in the logs:

1. `ssr.ts` installed Inertia's plugin and `ZiggyVue` and nothing else, while `app.ts` also
   installed vue-i18n and the `replaceIcons`/`getRarityColor` mixin. Every page calling
   `$t()`, which is every page, died with "Need to install with 'app.use' function".
2. `useRecaptcha()` called `recaptcha-v3`'s `load()` during `setup`. On the server that is a
   rejected promise nobody awaits, and Node exits on an unhandled rejection: **the first visit
   to `/login` killed the SSR process**, for every visitor, until something restarted it.
3. `Breadcrumb.vue` called the bare global `route()` inside a computed the template reads.
   That global is Blade's `@routes`, which exists only in a browser, so every page with an
   empty trail (the wiki index, the campaign create page) failed with "route is not defined".

What holds each of those now:

- **`resources/js/appPlugins.ts`** is the one list of what both apps install, and both entry
  points call it. It builds **a fresh vue-i18n instance per call**, never one at module scope:
  the SSR process loads the module once and serves every request from it, so a shared
  instance would hand one visitor's locale to the next. What stays out of it is what only
  one side can have: `vue3-storage` (it wraps `sessionStorage`) and Ziggy's configuration
  (Blade's `@routes` in a browser, the page's own `ziggy` prop on the server).
- **`resources/js/ssrRender.ts`** holds the render itself, apart from `ssr.ts`, because
  `createServer()` binds a port the moment it runs and a test cannot call it. `ssr.ts` hands
  `renderPage()` to `createServer()` and also **logs unhandled rejections instead of
  exiting**: each render is independent and holds no state, so carrying on is safe, and one
  stray promise in one component no longer takes server rendering away from the whole site.
- **`useRecaptcha()` loads the script from `onMounted`**, which only ever runs in a browser,
  and `execute()` loads it too so a submit can never race a mount.
- **A component that needs a URL while rendering injects `route`** (`inject('route')`),
  which `ZiggyVue` provides on both sides. Calling the bare global from a handler (a submit,
  a click) is fine and that is nearly every call site; it is only render-time code that has
  to avoid it.
- The title suffix comes from an `appName` shared prop (`config('app.name')`), because the
  SSR process is started without a `.env` and the `process.env.APP_NAME` it used to read was
  never there: titles came out as "Log in - " with nothing after.
- `@inertiaHead` sits **above** the static `<title>` in `app.blade.php`. With SSR on it
  prints the page's own title, and a crawler reads the first `<title>` in the document:
  below the static one, every page was indexed as the bare app name.

A fourth, found once the first three were gone: `WysiwygInput.vue` read `document` during
`setup` to pick its theme, so both campaign forms threw on the server. It is guarded now and
`md-editor-v3` itself renders on a server without complaint. The server draws the light
editor; the client renders the page again on load (see below), so a dark visitor still gets
the dark one.

**The client does not hydrate.** `app.ts` mounts with `createApp`, which clears `#app` and
renders from scratch, rather than `createSSRApp`, which would adopt the server's markup. So
the server HTML is what a crawler reads and what a visitor sees until the bundle runs, and
then it is replaced. Switching to hydration would remove that redraw but needs every
component to render the same thing on both sides, and several read `localStorage`,
`sessionStorage` or the `dark` class while setting up; it is its own piece of work.

`resources/js/__tests__/ssr.test.ts` renders every Wiki and Auth page, and both campaign
forms, through `renderPage()` in a real Node environment (`@vitest-environment node`, no `window`, no
`document`), which `smoke.test.ts`'s happy-dom could never do. It was checked against each of
the three faults put back in on purpose, and catches all three. One trap in it worth knowing:
`recaptcha.ts` caches its promise at module scope, so only the first page ever reaches
`load()`, and a `vi.fn()` whose history is reset between tests left the dedicated check
looking at an empty record and passing with the bug restored. The calls go into a
`vi.hoisted` array nothing resets, asserted empty after every page.

**To see it for real**: `npm run build`, `node bootstrap/ssr/ssr.js`, then request a public
page (`/`, `/login`) and look for `data-server-rendered="true"` on `#app`. The wiki redirects
to `/login` without a session, so following redirects silently tests the login page over
and over.

### The public page

`resources/js/Pages/Welcome.vue` is the whole of it, no partials.

**The hero draws one of three 4K stills from Capcom's video game at random.** That is other
people's artwork on a public page, and it is the same objection that keeps a portrait off
the monster card view, so the repository holds two standards here. It was raised, and the
owner decided to keep the stills. Recorded so the inconsistency is deliberate rather than
forgotten.

Two alternatives were tried and rejected before that decision. A screenshot of this app does
not work as a backdrop: blurred enough to sit behind text it is invisible under the 50%
veil, and legible enough to see it reads as a dimmed screenshot. A plain dark ground works
but leaves the hero empty.

The stills are 2048x1152 and 188-276 kB. They arrived as 3840x2160 and up to 608 kB, which
was the heaviest thing on the page by an order of magnitude. **Re-encoding them at their
original size made them larger**, 1.7 MB against 1.5, because they were already
well-compressed WebP and a second lossy pass only adds artefacts; the width was the whole
problem. They are encoded from the original JPEGs kept in git history rather than from the
WebP, so there is one lossy generation and not two. A local `cwebp` does this; there is
nothing for a service like TinyPNG to add to a WebP that is not already optimal, and it
would mean uploading the assets to somebody else to find that out.

The two content sections do carry real screenshots, in `resources/images/screens/`, taken
from the redesigned app rather than from 2023. The one they replaced showed flat white
Jetstream cards, a product that has not existed since `d0bb8bf`. Six orphaned source files
went with them, 2.4 MB that nothing had referenced since 2023.

There are three of them, one per content section: the campaign page, a hunter's armour tab
and the monster wiki. The hunter one needs a hunter that actually owns something, so the
local demo data equips one piece per slot and a handful of materials; captured empty it is
a column of zeros and sells nothing.

**Each exists in both languages and `Welcome.vue` picks by `locale`**, falling back to
English for anything else, as vue-i18n's `fallbackLocale` does. They are pictures of this
app's own interface, so an English one on a Spanish page reads as a different product. The
Spanish pair is captured with the demo campaign renamed too, otherwise the chrome is
translated and the content beside it is not.

**Capture them at a device scale factor of 2** (`agent-browser set viewport 1440 900 2`) and
export around 2200 px wide. The first pass shipped 1280 px and looked soft: both panels are
half-width and full-height, the wiki one is `bg-cover`, so the image is scaled up about 1.4x
just to cover before the display's own pixel ratio doubles it again. Roughly 130 kB reaches
a visitor, since only one language loads.

**Everything on the page reacts to `canRegister`, not just the buttons.** With
`AUTH_CAN_REGISTER` off, which is the default, hiding the register button used to leave an
"Or" separator with nothing to separate and a whole "3 easy steps" section telling visitors
to fill in a registration form that does not exist and has no link. Step one now says the
app is invitation only.

The page's `<Head>` carries a title and nothing else. `appTitle()` appends `" - <app name>"`
to it on both sides, so it holds only the distinguishing part. The description lives in
`resources/views/app.blade.php`. `@inertiaHead` now prints above the static title and
description (see "Server side rendering"), so a description given in a page component would
come first and win; none does today.

### Game icons

Seed data marks a game symbol as `:name_icon:`. `resources/js/icons.ts` holds the whole map
and `replaceIcons` swaps them, exposed as a global mixin method and used through `v-html`.
The token pattern only captures `[a-z0-9_]`, so nothing from the data can reach the markup
as anything but a name.

**That guarantee covers the substitution, not the sentence around it.** `replaceIcons` runs
`text.replaceAll(TOKEN, ...)`; anything outside a matched `:token:`, quotes and angle
brackets included, passes through completely unrewritten, because nothing here strips or
escapes it. Its output reaches `v-html` at 14 call sites, each traced: weapon type and song
effect descriptions, armour skill descriptions, monster ability, setup, broken-part and
mechanics text, and the reward table. Every one of those is seed data, none is anything a
visitor can type, so there is no live vulnerability today. But that is incidental to how the
callers happen to use it, not something `replaceIcons` itself enforces, and the day a
campaign description or a hunter's name is ever passed through it instead, that becomes
stored XSS. `resources/js/__tests__/icons.test.ts` pins the token boundary, not the absence
of a sanitizer: a literal `<script>` next to a token is left exactly as written, which is
the documented behaviour, not a bug that test is catching.

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

**The `alt` and `title` text in `icons.ts` stays in English, deliberately.** About twenty
strings (`'Fire'`, `'Damage attack'`, `'Fire resistance'`, ...) sit there untranslated and
are the only such strings left in the app; 147 components were audited and every one of
them uses `$t()` or `__()`. Translating these is not a matter of wrapping them: the file is
a plain module shared by SSR, where a single i18n instance imported at module scope would
mix the locale between concurrent requests, so it would mean threading the locale through
`replaceIcons` or resolving the text in the components. Judged not worth that for alt text
on a decorative symbol. Revisit only if a screen reader user complains.

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

### Dependency updates

`.ncurc.json` sets `upgrade: true` and `install: always`, so plain **`ncu` applies and
installs rather than reporting**, majors included. Worth knowing before running it: there
is no step between "what is new" and "it is in your tree now".

**`typescript` is in `reject`.** No release of typescript-eslint runs against TypeScript 7,
so taking that bump breaks `npm run lint` outright and fails the frontend job in CI. The
failure names typescript-eslint rather than the package that moved, which is why it is
worth the line. Remove the rejection once typescript-eslint ships support; the tracking
issue is typescript-eslint#10940.

It is there because it already happened: an `ncu` run took typescript 6 to 7 along with
@vueuse 14 to 15 and md-editor-v3 6 to 7, the result sat unstaged, and a `git add -A` in an
unrelated commit swept all of it in. Lint had been green minutes earlier, so the breakage
was reported as passing. Read the diff before committing; `git add -A` is how that gets
missed.

The other two majors were never rejected, and on 3 October 2026 they were taken: @vueuse 15
and md-editor-v3 7 pass lint, typecheck, Vitest (including `wysiwygInput.test.ts`, which
fails on any remote asset the editor loads), the build and the Dusk suite unchanged.

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
`main`, and `dusk.yml` runs the browser suite in `tests/Browser`. All three pin every action
to a commit SHA with the version in a trailing comment; keep that style when bumping.

The workflow **must** stay on PHP 8.5 or newer. `config.platform.php` is pinned to 8.5.0, so
`composer install` happily succeeds on an older PHP (it simulates 8.3 when resolving) and
then every subsequent `php` call dies in `vendor/composer/platform_check.php` with
"Your Composer dependencies require a PHP version >= 8.5.0". The failure surfaces at
`artisan key:generate`, nowhere near the real cause, so check the PHP version first.

The workflow does not set `DB_CONNECTION` or `DB_DATABASE`. PHPUnit's `<env>` entries do not
override variables that already exist in the environment, so setting them in the workflow
silently overrode the `sqlite :memory:` from `phpunit.xml` with a file database. Leave them
unset and let `phpunit.xml` decide.

`pest --parallel` is deliberately not used, though the case against it has not aged well
and is worth restating rather than patched over. It used to lean on the suite taking six
seconds, cheap enough that the added moving parts of running it in parallel would not pay
for themselves. The suite takes about 42 seconds now, measured rather than guessed, and
almost none of that growth is new work: the twenty tests in `tests/Feature/TypeScript/`,
which cover the types generated for the frontend, cost about 0.72s together, and the ten
slowest tests in the whole run, all pre-existing, are seeder tests exercising the full
weapon, armour and monster data. `TestCase::setUp()` seeds once per test whether the suite
runs serially or across parallel workers, so parallelism does not remove that cost, it only
has a chance to overlap it across processes that each also pay their own bootstrap, and
whether that trade is worth it has not actually been measured. What is measured is that ten
specific tests account for more than a quarter of the suite's time, which is the cheaper,
already-identified thing to fix before reaching for the harness. Revisit `--parallel` if
those tests are fixed and the suite is still slow enough to matter.

The `frontend` job runs `npm ci`, `npm run lint` and `npm run build` on Node 22. It also
installs the composer packages (`--no-dev`), because `resources/js/app.ts` imports Ziggy
from `vendor/tightenco/ziggy/dist/vue.m`, so the build fails with an unresolved import if
`vendor/` is absent. It needs no `.env`. Node 22 is the floor: `readdirp` and `sass` require
`>= 20.19`, and `glob`, `jackspeak` and `lru-cache` require `20 || >=22`.

**`dusk.yml` is its own workflow, not a job in `laravel.yml`**, so a flaky browser cannot fail
the fast suite it runs alongside. Unlike `laravel.yml` and `sentry.yml`, it triggers on every
push and pull request rather than only against `main`.

It runs against MySQL rather than the Pest suite's sqlite `:memory:`, because Dusk drives the
application through a real HTTP server (`php artisan serve`) in a second process, and an in
memory database exists only inside the process that opened it: the server and the assertions
would each be talking to their own empty database. `phpunit.dusk.xml` already declares its own
`Browser` testsuite for this, so nothing was added to `phpunit.xml`; that file stays scoped to
what `vendor/bin/pest` runs, or an ordinary test run would try to start a browser too.

`npm run build` runs before Dusk for the same reason it runs before the `frontend` job's own
checks: without `public/build`, Inertia 3 loads the page and `#app` stays empty, and nothing
reaches the console, so a Dusk assertion against a page that never mounted fails with no hint
that the real cause was a missing build.

**`.env.dusk.ci` is committed and holds no secret.** `APP_KEY` is generated by the job rather
than stored, and the reCAPTCHA pair in it is Google's own published test keys, documented to
always verify and never return a score, which `App\Rules\Recaptcha` already treats the same as
an unreachable Google. Its `DB_DATABASE` has to read `monster_hunter_dusk`, matching
`phpunit.dusk.xml`'s own `<env name="DB_DATABASE">`: the workflow's `cp .env.dusk.ci .env` step
feeds the served application, while PHPUnit's `<env>` entries feed the Dusk process that drives
the browser, and the two only end up looking at the same data if they agree on its name. A
mismatch there would have the browser writing to one database and the assertions reading
another, and the failure would look like nothing at all.

**Its mailer is `log`, and has to stay something that needs no server.** Registering sends
the verification mail inside the request (`QUEUE_CONNECTION=sync`), and nothing listens on a
mail port on the runner, so with SMTP the register POST is a 500 and `AuthTest::register`
times out on "waited 5 seconds for location [/email/verify]". It never shows locally, where
Herd's own mail server answers on 2525 and `.env.dusk` keeps SMTP.

Screenshots and console logs from a failing run upload as an artifact
(`tests/Browser/screenshots`, `tests/Browser/console`); a Dusk failure without them is close to
unreadable.

`tests/Browser/CampaignTest.php` creates a campaign in Chrome end to end (default box, the
timer moving with the boxes, the base game guard, manual mode). Locally the suite runs with
`php artisan dusk` against the Herd site, after `php artisan dusk:chrome-driver --detect` once
and an `npm run build` so the site serves current assets.

**Every browser test starts by clearing the served app's file cache**
(`resetServedAppCache()` in `tests/Browser/helpers.php`). Without it `AuthTest::register`
failed one run in five locally with only "waited 5 seconds for location": the email
verification route is `throttle:6,1`, the served app keeps its limiter in the file cache,
which outlives every run, and `DatabaseTruncation` hands the same user ids out each time, so a
seventh run inside a minute was refused. Eight back-to-back registrations reproduced it
exactly. It is `cache:clear file` and not `Cache::flush()` because this process runs on the
array store `phpunit.dusk.xml` sets while the served app uses the file store `.env.dusk`
names. CI runs the suite once and never met it.

**Chrome's password manager is off in the browser suite** (`DuskTestCase::driver()`), and
that is what finally made `AuthTest` reliable. It logs in and registers with `password`,
which is on Google's breach list; a second or so after the form submits, Chrome opens its
own "Change your password" dialog, which takes the input for itself. The page underneath
stays visible and scriptable and `elementFromPoint` still finds the button, but every click
and keystroke WebDriver sends from then on is reported as sent and never reaches the
document, for the rest of that browser session. Whether the test finished its clicks before
the dialog opened was a race: about one full run in seven failed, on "waited 5 seconds for
location [/]" after Log Out, and the next test in the same browser then found its typing
missing. `CampaignTest` logs in with `loginAs()`, never types a password, and never failed.
A probe that logged in and out ten times per browser failed in most rounds before the fix
and passed 80 cycles of 80 after it; the full suite went from two or three failures in 20
runs to none.

It took eliminating a long list first, each measured rather than assumed: slow waits (15
seconds failed the same way), the reCAPTCHA widget, the service worker, SPA navigation, the
`--disable-gpu`, backgrounding and site isolation flags, WebDriver's Element Click against
its Actions API, and a DOM re-render race. What gave it away was instrumenting the page:
between two markers around the click, not one `pointerdown` arrived, with focus, frames and
hit-testing all normal.

**Each browser session keeps its Chrome profile where `DuskTestCase` can delete it.** Left
to itself chromedriver puts a profile in a fresh `org.chromium.Chromium.scoped_dir.*` under
the system temp directory and removes it once Chrome exits, and Dusk stops chromedriver the
moment it has quit the browser, so it never did. Every session leaked 100 to 140 MB; a day of
running the suite left 197 of them, 5 GB, and the disk filling up took Herd's MySQL down
mid-migration (`monster_hunter_dusk`) and left Herd's PHP serving a fatal error from its
dump interception until `herd restart`. The profiles now live under
`sys_get_temp_dir()/monster-hunter-dusk-chrome`, emptied before every class and after it.
If the suite ever starts failing everywhere at once, check free disk space before the code.

### Checking mail works

`php artisan mail:test [recipient]` sends one real message through whatever mailer is
configured and reports which one that was, before sending, so a run that hangs on a blocked
port still says what it was reaching for. A transport failure is printed with the reason
Google or Mailjet gave and exits non-zero, which is the whole point: the question it answers
is "why does mail not work", and swallowing the SMTP error leaves that unanswered.

**A Pest test cannot answer that question.** The suite runs against the array mailer, so it
proves the command works and says nothing about whether Mailjet accepts the credentials or
whether the server can reach `in-v3.mailjet.com`. Only running this on that machine does.

The message is a markdown mailable (`App\Mail\TestMessage`), not `Mail::raw`, so it goes
through the same view rendering and layout as real mail rather than only proving that the
transport opens a socket. Its property is `$sentThrough` rather than `$mailer`, because
`Mailable` already declares one and a typed redeclaration is a fatal error.

Mailjet is an SMTP mailer in `config/mail.php`, using the API key and secret as username and
password. Set `MAIL_MAILER=mailjet`. There is no sandbox switch: Mailjet's sandbox mode is an
`X-MJ-Sandbox-Mode` SMTP header and nothing here sends it. `MAILJET_SANDBOX` used to sit in
`.env.example` implying otherwise, which is worse than its absence, so it is gone.

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

**A hunter spends a downtime day on up to three different activities.** The number is
`Campaign::MAX_DOWNTIME_ACTIVITIES`; `AddOrUpdateCampaignDayRequest` asserts it and
`CampaignController::show` sends it to the page as `maxDowntimeActivities`, so the two
modals that build a day do not write a 3 of their own.

It was briefly a per-campaign opt-in, `campaigns.alternative_rules`, added and then
dropped a week later (`..._make_three_downtime_activities_the_rule`) once the rulebook
text went in: the second entry under `downtime` in
`resources/lang/en/campaign-rules.php` states the three flatly, with no alternative
attached, so there was nothing for the flag to switch between. Nothing was deployed with
it, so the rollback restores the column at its default rather than any campaign's value.

The storage is the pivot: `day_downtime_activity_hunter` gets one row per hunter per
activity, which it could already hold (it has its own `id` and no unique key).
`days.downtime_activity_id` is the party's single activity and is filled only when
everybody spent the day on one, so a set leaves it null and the pivot rows are the whole
answer. `day.hunters` therefore repeats a hunter once per activity, which
`CampaignDay.vue` and `UpdateCampaignDayModal.vue` both group back by hunter; rendering
the raw list prints the name three times under duplicate `:key`s.

**The three have to be different, and that is checked by hand in the request's
`after()`**, not with Laravel's `distinct`. `distinct` on `hunter_day_id.*.*` compares
every entry against every other one across the whole array, so it would also refuse two
hunters choosing the same activity, which the rules allow and which is the common case.
It is correct on `day_id.*`, a flat list, and is used there.

`prepareForValidation()` widens the old scalar shape (`day_id` and each `hunter_day_id`
entry as a single id) into a one-entry list, so the rules and the controller read one
shape and a caller that still sends the old one keeps working.

Two bugs came out of this and are fixed: `days.all_hunters_same_activity` was never in
`Day::$fillable`, so every `update()` of it was silently discarded and the edit modal
always opened on the per-hunter branch; and `updateDay`'s reconcile-in-place branch
attached a hunter it had not seen before with the whole party's activity instead of
their own. It detaches and rewrites now.

`tests/Feature/Campaign/DowntimeActivitiesTest.php` covers it.

**`campaigns.expansions` records which boxes are in play, and the timer follows
from it.** It is a nullable JSON column of `App\Enum\MonsterExpansion` case
names rather than a pivot table, because an expansion is an enum case and there
is no row to point at. `Campaign::expansionCases()` reads it, dropping a name
the enum no longer declares rather than throwing: a renamed case should cost an
expansion off a listing, not the ability to open the campaign at all.

**Two of the eight cases are base games, not expansions.** The Ancient Forest
and the Wildspire Waste are each a complete game, and a campaign is played out
of one of them or both, so `App\Rules\IncludesABaseGame` refuses a set of
expansions with neither. `MonsterExpansion::isBaseGame()` is the distinction and
it exists only for this: everywhere else the enum appears (a monster's box, a
weapon recipe's, an armour's) the question is just which box a thing came out
of. The two forms show the base games and the add-ons as separate groups for
the same reason.

The rule is `sometimes`, not `required`, so a request that never mentions
expansions leaves them alone. That is what keeps a plain rename working and
what keeps every campaign stored before the column existed saveable. The flip
side, which is deliberate: both forms always send the key, so a campaign with
no base game recorded cannot be saved from either of them until one is ticked.

**Both forms say so before they submit**, through `hasBaseGame()` in
`resources/js/campaign.ts`, which reads what counts as a base game off the
options the page was given rather than off a list of names of its own. It
writes the refusal with `form.setError('expansions', ...)`, the same key the
server's own message arrives under, so the one `InputError` beneath the base
game group renders whichever side refused. **The sentence is the rule's own
literal, character for character**: `IncludesABaseGame` `__()`s it, which is
what puts it in the lang files at all, and the `t()` call in the forms looks
that same key up. Change one without the other and the client shows English
where the server would have shown Spanish.

The create form opens with one box already ticked.
`MonsterExpansion::defaultCampaignBox()` names it (the Ancient Forest) and
`CampaignController` sends it as `defaultExpansions`, rather than the form
holding the string: renaming the case would otherwise leave the form ticking
nothing and failing its own guard on first submit.

`Campaign::suggestedMaxDays()` is `BASE_MAX_DAYS` (25, the number the first
downtime rule states in words) plus each expansion's
`MonsterExpansion::extraCampaignDays()`. Neither base game adds anything: 25 is
what the core rulebook gives you whichever of the two you own, and owning both
does not lengthen it. Picking Bones adds 15 and the five monster expansions add
5 each. `CampaignTimerTest` parses the English rule text for "add N days" and
fails if it disagrees with the enum, so the two statements of that fact cannot
drift.

**`campaigns.max_days_automatic` is enforced in a `saving` hook, not in the
controller.** With it on, `Campaign::booted()` overwrites `max_days` with the
suggestion on every save, from any path: the two forms, the factory, the
seeders, a future console command. That is what makes "automatic" a property of
the row rather than of the screen that happened to write it, and it means the
number a client posts for an automatic campaign can never land. It defaults to
false so every campaign that already exists keeps the timer somebody typed.
`CreateCampaignRequest` and `UpdateCampaignRequest` only require `max_days`
when the campaign is on manual.

`CampaignTimerFields.vue` is the expansion checkboxes, the switch and the field,
shared by the create and the edit form rather than written twice, so the two
screens cannot compute the timer differently. On manual it still prints the
suggestion under the field: turning the switch off is for overriding the number,
not for losing sight of it. `CampaignRules.vue` now shows the rules for the
expansions in play only; it listed all eight while nothing recorded which ones a
campaign uses. It renders three kinds of section: `campaign-rules.base` (the
core rulebook's own rules, which hold whichever base game is in play, so they
are not keyed by expansion), `campaign-rules.downtime`, and one per selected
expansion. `base` is an empty list today and an empty list renders nothing.

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

### reCAPTCHA

**It is v3, and v3 is already the version that never shows a challenge.** Proved by a real
`siteverify` call returning `score` and `action`, which only v3 keys do. "Invisible
reCAPTCHA" is the name of a *v2* variant and is less invisible than this: no checkbox, but
it can still interrupt with images. Keys are not interchangeable between v2 and v3, so
switching would mean a new pair.

**The badge is hidden and `Components/RecaptchaNotice.vue` stands in for it.** Google asks
for the badge *or* a visible attribution, one of the two, so `recaptcha.ts` leaves
`autoHideBadge` to do its job and never calls `showBadge()`. Every form that calls
`useRecaptcha` has to render that component or the app stops holding up its end of Google's
terms. Note this is not obviously an improvement and was a deliberate choice: the badge was
a 70 px sliver in one corner of two pages, the notice is a line of small print inside five
forms.

`recaptcha-v3` always loads `api.js?render=explicit` and renders the widget itself, deleting
any `render` parameter passed to it. That URL is not a sign of v2.

**Always pair the rule with `required`.** `App\Rules\Recaptcha` is not implicit, so Laravel
skips it when the attribute is absent, and a POST that simply left `captcha_token` out used
to sail past without Google being asked at all. That hole is also what kept the suite green,
since no test sent the field.

**Every public form that sends mail or creates an account carries it**: login, register,
`forgot-password`, and both invitation acceptances. `forgot-password` was the softest target
of the lot, since Fortify applies no rate limiter to it and it emails whoever is named. Its
rule arrives through `App\Http\Requests\SendPasswordResetLinkRequest`, bound over Fortify's
own in `AppServiceProvider`, the same way `LoginRequest` already was. The two invitation
controllers validate inline, so the rule goes in their `$request->validate()` array.

`reset-password` and `two-factor-challenge` deliberately do not have it. Both already
require a token or a pending login session, so there is nothing to spam, and Fortify
validates the first of them inline inside a vendor controller with no FormRequest to extend.

The threshold lives in `config/services.php` under `google-recaptcha.score`, not written out
at each call site. **An unreachable Google lets the request through** and logs a warning:
locking every existing user out of their own account during an outage at Google is worse
than the spam that gets in during it, and the rate limiter still applies.

### Testing and the network

`tests/Pest.php` calls `preventStrayRequests()` before every Feature test, so a request it
does not fake fails the test rather than going out. This is not theoretical: the first
version of that hook was chained wrong, did not apply, and a test came back with a genuine
`invalid-input-response` from Google, with the local secret, which is what CI would have
done too.

Use **`fakeRecaptcha($payload)`** rather than `Http::fake()` to change the answer.
`Http::fake()` accumulates and the *first* registered stub wins, so layering a second call
on top of the one every test starts with silently does nothing. The helper replaces the
client instead.

**`phpunit.xml` sets `INERTIA_SSR_ENABLED=false`.** Without it every Inertia render in the
suite opens a connection to the SSR server on `127.0.0.1:13714`, fails, and quietly falls
back to client rendering. It stayed invisible until `preventStrayRequests` turned it into 88
failures at once.

### Frontend tests

`resources/js/__tests__/` holds one unit-test file for each of six pure, stateless modules,
`damage.ts`, `armorDefense.ts`, `armorSkills.ts`, `rarity.ts`, `icons.ts` and `campaign.ts`. The first
five were converted to TypeScript earlier on this branch (see "The TypeScript conversion"
above) and `campaign.ts` was written in it; the
test files themselves were `.test.ts` from the day they were written, before that conversion,
for the reason the next paragraph pins. `smoke.test.ts` mounts every page and partial under
`Pages/Wiki` and every page under `Pages/Auth`, and asserts each one renders something and
warns about nothing; Auth was added as the cheapest useful widening beyond the Wiki, since
nineteen of the Wiki's 29 shared components are also used outside it and the Wiki glob alone
cannot see that. `ssr.test.ts` renders the same pages through the real SSR render function
in Node (see "Server side rendering"); the props both suites hand those pages live in
`pageProps.ts`, so the two cannot drift into testing different data.
`campaignForms.test.ts` mounts `Campaign/Create.vue` and `Campaign/Edit.vue` whole.
`campaignShow.test.ts` mounts `Campaign/Show.vue` and follows `maxDowntimeActivities` down
to the add-day button and every day's edit modal. `npm run test:run` is Vitest: 13 files,
130 tests, and the run is meant to stay pristine, no skips and nothing printed.

`setup.ts` skips its DOM mounting under `@vitest-environment node`, which only `ssr.test.ts`
uses, and exports the fake page's shared props as `sharedPageProps` for it. It also provides
`route` through `config.global.provide`, the third way Ziggy reaches a component and the
only one that works on the server.

**Stub `router.post`/`router.put` in any test that submits an Inertia form.**
`useForm().post(...)` ends up at `router[method](url, data, options)`, which under
happy-dom fires a real XHR at a server that is not there and surfaces as an unhandled
rejection after the test has already passed. Stubbing them also turns "did it submit"
into something assertable either way, which is how the base-game guard is pinned.
And scope `find('form')`: `AppLayout` carries a logout form of its own and it is the
first one in the document, so the obvious selector submits that instead.

**Mount the page, not just the partial.** `Create.vue` took `baseMaxDays` from the
controller and never declared or forwarded it, so `CampaignTimerFields` added
`undefined` to the expansions' days and every create page read "Suggested: NaN days".
Both forms had tests; neither page did, and the prop never crossed a boundary any of
them watched. `Edit.vue` was correct, which is why only half the feature was broken.
The same test's warnings assertion then caught a second, older one: both `Create.vue`
and `CreateCampaignForm.vue` declared `teams: Array` while the controller sends
`allTeams()->pluck('name', 'id')`, an object, so every visit to the create page logged
two "Invalid prop" warnings.

**`WysiwygInput` is stubbed for the whole suite.** It is 861 kB of CodeMirror that no
page test is about, and it was stubbed in the first place because it fetched from
`unpkg.com` as it mounted, which happy-dom really tries. It no longer does (see "Rich
text"), but the stub stays for the weight. `wysiwygInput.test.ts` is the one suite that
mounts the real thing, as the root component, where a child stub does not apply.

The fake page's `auth.user.current_team` is a real object rather than `null`.
`CreateCampaignForm` reads `usePage().props.auth.user.current_team.id` unguarded, so a
null one makes any campaign page throw on mount. The team-switching branches it used to
keep out of the picture are gated behind `jetstream.hasTeamFeatures`, which stays false,
and the four snapshots are unchanged by the switch.

They were written against plain JavaScript, before any file moved to TypeScript, and that
ordering was deliberate rather than incidental. Written afterwards, a test can only describe
what a conversion actually produced, bug included; a component that started rendering nothing
after its move would simply become the new expected result. Written first, against behaviour
nobody disputed yet, they are characterisation tests: whatever changes a component afterwards,
including a later move to TypeScript, cannot change what it does without turning one of them
red.

**`resources/js/__tests__/setup.ts` is what makes any of that possible**, and none of its
pieces are there for decoration. `@vue/test-utils`'s bare `mount()` knows nothing about this
app's plugins, so it installs a `vue-i18n` instance with an empty message catalog and both
of its warnings disabled, since no component's rendering is supposed to depend on the actual
translated text, only on `$t()` existing and returning something printable. It sets up
Ziggy's `route()` twice: once as a real global, for `<script setup>` code that calls it
directly, and once as a mixin method, because a component whose *template* calls
`route(...)` reaches it through `_ctx.route`, not `globalThis.route`, and a setup that only
did the first looks correct right up until that component throws "route is not a function".
`replaceIcons` and `getRarityColor`, the app's two other global mixin methods, go in beside
it for the same reason: nothing in `@vue/test-utils` knows about a mixin `app.ts` installs at
runtime. And rather than stub Inertia's `Link` and `Head` and reimplement what `usePage()`
needs, it mounts Inertia's real `App` root once, with a fake `initialPage`, because
`usePage()`'s state lives in a module-level ref that only a genuine mount populates; several
components read `$page.props` or call `usePage()` directly (`AppLayout.vue`, `Banner.vue`,
`LocaleDropdown.vue`, and others reached through every Wiki page's layout), and stubbing
would leave every one of them with nothing to read. Miss any single piece here and the
failure is not a crash, it is a console warning, which is exactly what `smoke.test.ts`
catches and fails on.

**Two assertions in `smoke.test.ts` look removable and are not.** Each glob
(`import.meta.glob('/resources/js/Pages/Wiki/**/*.vue')`, and the `Pages/Auth/**/*.vue`
one added beside it) is asserted to match at least as many files as it did when written, 16
and 9, before anything else runs, because a glob matching nothing turns every `it.each` below
it into a vacuous pass, and this repository has already shipped exactly that failure once: a
green `npm run typecheck` that walked 175 files and checked none of them. Two glob calls carry
two separate guards rather than one merged brace pattern, so that one side silently matching
nothing cannot hide behind the other side matching plenty. The `warnings`
assertion, that a mount produced none, is the other one: `CraftWithHunter.vue` gates its
whole template on `! (weapon?.is_default || armor?.is_default)`, the shared fixture bag
handed it a `weapon` with `is_default: true`, and the component rendered `<!--v-if-->` and
nothing else, non-empty and silent, so it passed on "rendered something" while exercising
none of its own markup until that fixture value was corrected. A mount assertion alone would
still be green on that bug.

### Local environment traps

**Do not set `SESSION_DRIVER=cookie` locally.** Production uses `database` and so does
`.env.example`. With the cookie driver the whole session travels in the cookie and every
response rewrites it, so two concurrent requests clobber each other and a flashed
validation error is lost. The symptom is precise and misleading: a failed login redirects
correctly, the server sends the error, and the page shows nothing at all. Hours went into
that one before the driver turned out to be the difference.

### Deleting things

**Almost every foreign key in the campaign tree is declared `constrained()` with no
`onDelete`, which is RESTRICT.** That is not a style choice anyone made, it is the default,
and it meant the whole delete chain was broken at three levels until it was fixed:

- Deleting an account failed outright for anyone who had ever created a campaign.
  `DeleteUser` purges the owned teams, `campaigns.team_id` is RESTRICT, the foreign key
  took the transaction down and the account survived. Right to erasure, not honoured.
- Deleting a campaign failed for any campaign whose hunters were equipped, because a
  hunter's weapons, armours, items, downtime days and palico are all RESTRICT too.
- Sessions (with IP and user agent) and pending `password_reset_tokens` have no foreign
  key to `users` at all, so they outlived the account either way.

So the order below is forced by the schema, not chosen, and changing it breaks things:

1. `Hunter::booted()` has a `deleting` hook that detaches the four pivots and deletes the
   palico. **Hunters must be deleted one at a time**, never through a mass delete on the
   relation, because a mass delete fires no model events and the hook would not run.
2. `Campaign::purge()` does hunters, then days, then memberships, then itself. Both
   `CampaignController::destroy` and `DeleteUser` go through it; it used to be duplicated
   in the controller and absent from the account delete.
3. `DeleteUser` resolves the owned campaigns *before* purging the teams. A campaign with
   other members is handed to the longest standing admin (or the longest standing member)
   and moves to that person's team; a campaign the leaver held alone is purged.

`teamFor()` creates a team when the heir owns none. That is defence for accounts made
before `App\Actions\PrepareNewAccount` existed, not a live path any more.

**Every registration path goes through `App\Actions\PrepareNewAccount`.** The three had
drifted, each doing a different subset of the same job: `CreateNewUser` gave out the
`standard` role and a personal team, `SocialAuthController` gave out a team and switched to
it but no role, and `RegisterInvitedUser` gave out neither, so an invited account owned no
team and `campaigns.store` requires a `team_id` that exists and belongs to the caller. Every
step in the action is conditional, so calling it twice changes nothing. Add a fourth door
and it calls this, or it will drift too.

Jetstream's `deleteProfilePhoto()` returns early unless `Features::profilePhotos()` is on,
and it is commented out in `config/jetstream.php`. Its upload counterpart has no such guard
and is reachable through Fortify's `profile-information` route, so `DeleteUser` removes the
file itself rather than calling a method that does nothing.

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

3. **Reference text that is a list**, which so far means the campaign rules in
   `resources/lang/{en,es}/campaign-rules.php`. These are directory-based PHP
   lang files, not the JSON ones. Edit them by hand and keep the two languages
   in step, since the form renders one bullet per entry and a shorter list just
   shows fewer rules.
   **`artisan localize` rewrites these files, it does not leave them alone.**
   This file claimed the opposite for one commit, and the claim cost the two
   long header comments that used to explain why the rules live here: the
   command reads every PHP lang file and writes it back out, dropping comments
   and re-keying a list as `'0' => ...`, `'1' => ...`. The re-keying is
   harmless (PHP casts a numeric string key to an int, so it is still a list by
   the time it is serialised, and `tm()` still receives an array), the comment
   loss is not, which is why the explanation lives here instead. **Do not put
   anything but translatable text in them**: a day count, a flag or an id would
   survive the rewrite but belongs with the code that reads it, which is why
   `MonsterExpansion::extraCampaignDays()` holds the "+15 days" that the
   Picking Bones rule text also states in words.
   `artisan vue:translations` mirrors them into the generated file as real
   nested arrays, and `CampaignRules.vue` reads them with vue-i18n's `tm()` plus
   `rt()`, which is the only place in the app that reads the catalog as a list
   rather than as a string. They used to sit in
   `database/seeders/data/downtime-activities.php` beside the activities, where
   nothing seeded them because no table wants them. `config/` was the other
   candidate and was rejected: see "Seeding" for what `config:cache` did to the
   431 kB of seed data that used to live there.
   `tests/Feature/CampaignRulesLangTest.php` pins the two languages against each
   other and against `App\Enum\MonsterExpansion`, whose case names key the
   per-expansion rules; `resources/js/__tests__/campaignRules.test.ts` pins the
   `tm()` read itself.

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

**`php artisan db:seed` is safe against any database now.** `DatabaseSeeder` runs the eight
content seeders always and the three demo ones (`UserSeeder`, `CampaignSeeder`,
`HunterSeeder`) only outside production.

It used to run all eleven, which broke twice over on a server. The demo three build their
rows with factories, factories need `fakerphp/faker`, and faker is `require-dev`, so
`composer install --no-dev` left it out and the command died on a missing class. Had it not
died, it would have been worse: `HunterSeeder` attaches an invented hunter to a real
campaign and repoints the membership at it.

Note `db:seed` refuses to run unprompted in production at all, hence the `--force` in
`deploy.sh` and in the test that covers this.

### Rolling back

**`migrate:refresh` was broken and is now covered.** Six migrations had no `down()` at all.
A migration without one is skipped silently on the way back rather than failing, so its
tables survive the rollback, and the next migration to drop something they reference dies:
here it was `weapons`, refused because of a foreign key from `weapon_recipes` that nothing
was ever going to remove.

The three that create tables drop them now. `create_weapon_recipes_table` also puts
`branch` and `branch_id` back on `weapons` and copies the first recipe's values into them,
which is lossless except for the two dual blades buildable two ways, the case the table
exists for.

The three repair migrations have a **deliberately empty** `down()`, each saying why.
`add_the_columns_missing_from_drifted_tables` gives older databases columns their create
migrations already declare, so dropping them on the way back would take a column away from
a database that never needed the repair. The other two dropped tables no migration declares
and schema belonging to a package that is no longer installed; there is nothing to rebuild
them from.

The three campaign migrations of late September and early October
(`..._let_a_campaign_play_by_the_alternative_rules`, `..._record_which_expansions_a_campaign_plays_with`,
`..._make_three_downtime_activities_the_rule`) were checked that way on MySQL 9.4 on 2 October
2026: `migrate`, `migrate:refresh --seed`, then each rolled back and re-applied one at a time
with the column list compared at every step.

`tests/Feature/MigrationsTest.php` fails on a migration with no `down()`, which is the
mistake that was made. It cannot catch a `down()` that undoes things in an order the
foreign keys refuse, and sqlite would not report that anyway. **Check that against MySQL**:
create a scratch database, `migrate`, then `migrate:refresh --seed`. Running it on a
database that is already half rolled back proves nothing, since the records of the
migrations that failed are already gone.

### The first account

**`php artisan invitation:create [email] [--from=]`** issues a platform invitation and
prints its link. That is how the first account on a fresh database gets in: registration is
closed by default, and the seeders no longer invent an admin.

The admin they used to invent came with its password in `ADMIN_PASSWORD`, which on the
production server was the word `password`. An invitation is better on its own terms as well
as safer: whoever accepts chooses their own.

**`invitations.inviter_id` is nullable, and null means the console.** An invitation needs a
user, and on an empty database there is no user to be one, so the alternative was inventing
a system account that would show up in every listing forever. The acceptance page falls
back to the application's name where it would otherwise print the inviter's.

Nothing is emailed and the link is printed once, because the table stores only a hash of
the token and it cannot be recovered afterwards.

**Renaming an entry creates a row rather than renaming one**, because every seeder matches
on `name->en`. `Concerns\PrunesRemovedEntries` cleans up after that: once a seeder has
written everything its data file declares, it deletes the rows of that model whose English
name is not among them. Renames, and entries dropped outright, no longer leave anything
behind.

**A row something still points at is kept, not forced.** Deleting an item a hunter is
carrying is data loss, and the foreign key refuses it anyway. Rows are deleted one at a
time so that one refusal does not abandon the rest of the seed, and whatever survived is
named in the output rather than passed over:

```
Removed 1 items the data no longer names.
Kept 1 items that something still points at: Held Ore.
```

Weapons are pruned before weapon types, since a type still holding weapons cannot go and
reporting it as held would be noise when the weapons are about to be removed anyway.

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
  (`$page.props.level`, `$page.props.user.achievements`, which reads
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
| Tests | 82 pass, 8 skipped | 327 pass, 7 skipped |

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
