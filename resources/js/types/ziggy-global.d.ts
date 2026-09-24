// ziggy.d.ts is generated and has its own top-level `export {};`, which makes
// it a module, which makes its `declare module 'ziggy-js' { interface
// RouteList {...} }` an *augmentation* of an existing module rather than the
// creation of one. Nothing else in the program ever established 'ziggy-js' as
// a real or ambient module (there is no such package in node_modules), so
// that augmentation had nowhere to attach: every `RouteList` reference from
// another file silently resolved to an unresolvable-module error type,
// `keyof` of which accepts any string, which is exactly the typo that was
// supposed to be a compile error passing silently. This line is the fix: it
// creates 'ziggy-js' as an ambient module, empty, so ziggy.d.ts's own
// augmentation has something to merge into.
//
// The trick only works from a *script* file, one with no top-level
// `import`/`export` of its own; the same declaration inside a module file
// would itself be read as another augmentation attempt, same as ziggy.d.ts's,
// and go nowhere. That is why this file never has a top-level `import` or
// `export` statement (see `import('ziggy-js')` below instead of one), and why
// `route()` is declared with plain top-level `declare function` rather than
// wrapped in `declare global {}`, which is only legal inside a module.
declare module 'ziggy-js';

// The Ziggy plugin installs route() as a global and as a mixin method; this
// is what connects that global to the generated route list, and it is why a
// misspelt route name is a compile error rather than a thrown exception at
// runtime.
//
// Ziggy 1.8.2's own `vendor/tightenco/ziggy/src/js/index.d.ts` is more
// permissive than this: its `RouteName` is `keyof RouteList | (string & {})`,
// so an unrecognised name still compiles (it only loses autocomplete), and
// its bare `route()` returns a full `Router` (`current`, `has`, a `params`
// getter). This app deliberately narrows the second overload's name to
// `keyof RouteList` only, trading the "route name computed at runtime, not
// known statically" escape hatch for a compile error on a typo, which is the
// whole point of this file. The bare overload is narrowed the other way, to
// only what `Layouts/AppLayout.vue` actually calls on it
// (`route().current('wiki.*')`, including glob patterns Ziggy's `current()`
// matches against, which is why its argument stays a plain `string` rather
// than `keyof RouteList`).
declare function route(): {current(name?: string): boolean};
declare function route(name: keyof import('ziggy-js').RouteList, params?: unknown, absolute?: boolean): string;

// Blade's `@routes` directive (`resources/views/app.blade.php:26`) injects a
// second bare global, `Ziggy`, holding the same config object `route()`'s own
// optional fourth argument takes and that `ZiggyVue`'s `install()` forwards
// straight through: `app.ts`'s `.use(ZiggyVue, Ziggy)` (`ssr.ts` does not read
// this global; it builds the same shape from `page.props.ziggy`, typed in
// `inertia.d.ts`, since there is no Blade template to inject into during a
// server render).
//
// Ziggy names this shape `Config` in
// `vendor/tightenco/ziggy/src/js/index.d.ts`, but that interface has no
// `export` keyword, unlike `RouteList`, and `ziggy-js` is not an installed
// npm package to begin with (only `RouteList` is reachable at all, and only
// because the `declare module 'ziggy-js';` line above creates the module for
// `ziggy.d.ts`'s own augmentation to merge `RouteList` into). There is no
// import path to Ziggy's real `Config` by name, so it is transcribed here
// instead, field for field against that same file's `Config` and `Route`
// interfaces, rather than invented.
declare const Ziggy: {
    url: string;
    port: number | null;
    defaults: Record<string, string | number>;
    routes: Record<
        string,
        {
            uri: string;
            methods: Array<'GET' | 'HEAD' | 'POST' | 'PATCH' | 'PUT' | 'OPTIONS' | 'DELETE'>;
            domain?: string;
            parameters?: string[];
            bindings?: Record<string, string>;
            wheres?: Record<string, unknown>;
            middleware?: string[];
        }
    >;
    location?: {
        host?: string;
        pathname?: string;
        search?: string;
    };
};

// `ComponentCustomProperties` is augmented from `inertia.d.ts`, not here, and
// against `@vue/runtime-core`, not `vue`: see that file's own comment for why
// (`vue` re-exports `@vue/runtime-core` rather than being the module a
// template's type-checking actually consults, so augmenting it is inert).
// `declare module '@vue/runtime-core' {...}` for a real, already-resolvable
// package like that behaves as an augmentation only from inside a module file
// (one with a top-level `import`/`export` of its own); written here, in a
// script file (which this one has to be, for the `declare module 'ziggy-js';`
// line above to create rather than augment), it would instead replace
// `@vue/runtime-core`'s own module with an empty one, taking `ref`,
// `defineComponent` and everything else with it, for the whole program.
// `inertia.d.ts` already augments `ComponentCustomProperties` for
// `replaceIcons`/`getRarityColor` from a module file, so `route: typeof
// route` (this file's global) is added there instead; declaration merging
// across files is what makes that one interface either way.

// There is deliberately no declaration here for
// '../../vendor/tightenco/ziggy/dist/vue.m', the path app.ts and ssr.ts (Task
// 5) import `ZiggyVue` from. The plan called for one, wildcard or exact, on
// the theory that TypeScript never reaches `ziggy-js`'s own types for an
// import by file path. Measured instead of assumed: `vue.m.js` is a real file
// and `allowJs` is on, so TypeScript's own module resolution finds it before
// either an exact `declare module '../../vendor/tightenco/ziggy/dist/vue.m'`
// or a wildcard `declare module '*/vendor/tightenco/ziggy/dist/vue.m'` is
// ever consulted; both were tried and neither changed the inferred type of
// `ZiggyVue` at all (confirmed by forcing a shape neither could satisfy and
// reading the error TypeScript reported back: the real, inferred one, every
// time). What TypeScript infers straight from the JS, `{install: (t: any, r:
// any) => void}`, is untyped but perfectly usable: `app.use(ZiggyVue, Ziggy)`,
// with the real `Ziggy` global above (not a stand-in), already compiles
// against it with no declaration for `ZiggyVue` itself, because `any` accepts
// anything. A declaration that cannot win against real resolution and is not
// needed for the one thing that reads it is the failure mode this task exists
// to avoid, not a gap to fill.

