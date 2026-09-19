#!/usr/bin/env bash
#
# Deploy steps that run once the new code is on the server. It lives in the
# repository so the deploy is reviewed like any other change.
#
# The script in Forge only pulls and calls this one, and takes the lock, since
# the pull itself has to be inside it:
#
#     cd $FORGE_SITE_PATH
#
#     exec 8>/tmp/monster-hunter-deploy.lock
#     flock -w 5 8 || { echo "another deployment holds the lock; nothing to do"; exit 0; }
#
#     git pull origin $FORGE_SITE_BRANCH
#
#     export FORGE_PHP FORGE_COMPOSER
#     bash deploy.sh
#
#     ( flock -w 10 9 || exit 1
#         echo 'Restarting FPM...'; sudo -S service $FORGE_PHP_FPM reload ) 9>/tmp/fpmlock
#
# What this replaces built the frontend with yarn. The project moved to npm and
# deleted yarn.lock, and node 22 ships corepack, which already owns the `yarn`
# and `yarnpkg` shims in the nvm bin directory, so `npm install -g yarn` now
# fails with EEXIST and takes the deploy down with it. Nothing installs yarn
# here, and nothing should: two lockfiles would drift apart.
#
# Run from the site root.

set -euo pipefail

# Push to deploy fires twice for every commit, and two runs share this working
# directory: `npm ci` empties node_modules while the other is building, and vite
# empties public/build under it.
#
# It gives up almost at once rather than waiting. Forge caps a deployment at ten
# minutes and cancels an older one as soon as a new one is queued, so a run
# sitting on this lock only burns a deployment slot until Forge kills it. Losing
# nothing is already handled: Forge's own rule is that the newest push wins.
#
# Exits 0 because a duplicate trigger is not a failure. The deployment that
# holds the lock is doing the work.
#
# The lock in the Forge script also covers the pull, which this cannot, but only
# once that script has been updated. This protects the destructive half either
# way, on its own file so holding both cannot deadlock.
exec 7>/tmp/monster-hunter-deploy-steps.lock
flock -w 5 7 || {
    echo "another deployment holds the lock; nothing to do" >&2
    exit 0
}

PHP="${FORGE_PHP:-php}"
COMPOSER="${FORGE_COMPOSER:-composer}"

echo "--> PHP dependencies"
# Composer first: resources/js/app.js imports Ziggy from
# vendor/tightenco/ziggy/dist/vue.m, so the frontend build fails with an
# unresolved import if vendor/ is not already in place.
#
# require.php is ^8.5 and config.platform.php is pinned to 8.5.0, so composer
# resolves happily against an older binary and every later artisan call then
# dies in vendor/composer/platform_check.php instead. If this deploy fails at
# the next step with a version complaint, check the PHP version first.
$COMPOSER install --no-dev --no-interaction --prefer-dist --optimize-autoloader

echo "--> Dropping the caches of the previous release"
# Before migrating, so the migrations read the configuration that just landed
# rather than the one cached by the last deploy.
#
# It also drops the compiled Blade views, which matters more than usual since
# Inertia 3: it moved the initial page payload off a data-page attribute on the
# app div and into a script element, and a stale compiled view still emits the
# old shape. The failure is silent. The page and the assets load, #app stays
# empty, and nothing reaches the console, because createInertiaApp rejects
# rather than throwing.
$PHP artisan optimize:clear

echo "--> Frontend"
# No NODE_OPTIONS heap cap here, unlike the gym-manager script. Vite 8 builds
# through rolldown, which does its work in native code rather than in the V8
# heap, so --max-old-space-size governs the part that is not the problem and
# would only make the build fail earlier. A measured run of this build, client
# and SSR bundles together, peaks around 850 MB resident. If the server cannot
# afford that, give it swap or a bigger box rather than a cap that does nothing.
npm ci --no-audit --no-fund

# `npm run build` does not type check. That is the separate `npm run typecheck`
# script and it runs in CI, where a type error stops the branch rather than the
# deploy.
npm run build

echo "--> Removing files left behind by earlier builds"
# Vite only empties public/build. The service worker, its workbox chunk and the
# manifest are written to public/ itself, and the chunk name carries a hash, so
# every build that changes it leaves the previous chunk on disk forever. There
# were five of them in the working copy this script was written from, the oldest
# from July 2023.
#
# Only the chunk the current worker actually imports is kept. If that name
# cannot be read, nothing is deleted: an empty match here would remove the file
# the worker depends on.
current_workbox="$(grep -oE 'workbox-[A-Za-z0-9]+' public/sw.js | head -1 || true)"

if [ -n "$current_workbox" ]; then
    find public -maxdepth 1 -name 'workbox-*.js' ! -name "${current_workbox}.js" -delete
else
    echo "    could not read the workbox chunk from public/sw.js, leaving those files alone" >&2
fi

# Only emitted when the PWA plugin runs in development mode.
rm -f public/sw.js.map

echo "--> Storage link"
# The seeders put every monster, weapon type and item icon on the public disk,
# and the models build their URLs through Storage::disk(...)->url(), so without
# the symlink every icon in the wiki is a 404. The command does nothing when the
# link is already correct, so it costs nothing to run every time.
$PHP artisan storage:link

echo "--> Database"
# --force does not force anything destructive: it only stops artisan asking for
# confirmation in production, which a deploy has no terminal to answer.
$PHP artisan migrate --force

echo "--> Content seeders"
# `db:seed` with no --class is not safe here. DatabaseSeeder also calls
# UserSeeder, CampaignSeeder and HunterSeeder, which build demo data with
# factories, and HunterSeeder will attach a made up hunter to a real campaign
# and repoint the membership at it. Only the content seeders are named below, in
# DatabaseSeeder's own order, because the later ones look up rows the earlier
# ones create.
#
# They are idempotent and only add what is new, so re-running them is safe. They
# are still held behind a flag rather than run on every deploy, because a seeder
# matches on name->en: renaming an entry in database/seeders/data/ adds a row
# instead of renaming one and leaves the old one behind as an orphan that has to
# be deleted by hand. That is worth being a deliberate act.
#
# Set RUN_SEEDERS=1 for a release that changes the seed data. The site has "Make
# .env variables available to deployment script" enabled, so it can go in the
# environment file rather than in the Forge script.
if [ "${RUN_SEEDERS:-0}" = "1" ]; then
    for seeder in LevelSeeder RolesSeeder DowntimeActivitiesSeeder ItemsSeeder \
        ArmorSkillsSeeder MonstersSeeder ArmorsSeeder WeaponsSeeder; do
        echo "    $seeder"
        $PHP artisan db:seed --class="$seeder" --force
    done
else
    echo "    skipped: RUN_SEEDERS is not set. See the comment above." >&2
fi

echo "--> Rebuilding caches"
$PHP artisan config:cache
$PHP artisan route:cache
$PHP artisan view:cache
$PHP artisan event:cache

echo "--> Server side rendering"
# vite.config.mjs builds an SSR bundle into bootstrap/ssr, and there is no
# config/inertia.php, so the package default applies and Inertia uses an SSR
# server whenever one answers. The daemon has to be told the bundle changed or
# it keeps rendering the previous release; Forge starts it again.
#
# Nothing answering is the normal case while SSR is not deployed, and it is not
# a failure, so it is reported and stepped over.
$PHP artisan inertia:stop-ssr >/dev/null 2>&1 \
    || echo "    no SSR server answered, nothing to restart"

echo "--> Queue"
# Horizon supervises the workers, so it is the one that has to be told the code
# changed. It stops the master process; the daemon that Forge keeps alive starts
# it again with the new code. `queue:restart` would not reach them.
$PHP artisan horizon:terminate

echo "--> Done"
