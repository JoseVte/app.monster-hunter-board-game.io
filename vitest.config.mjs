import {resolve} from 'path';
import {defineConfig, mergeConfig} from 'vitest/config';
import viteConfig from './vite.config.mjs';

// laravel-vite-plugin's `config` hook throws whenever a `CI` env var is present and the
// command isn't `build`, on the assumption that someone is about to start the Vite HMR
// server inside a CI pipeline. Vitest reuses this same plugin, via vite.config.mjs, purely
// to resolve aliases; it never starts a dev server, but the plugin cannot tell the two apart.
// Without this, `vitest run` throws "You should not run the Vite HMR server in CI
// environments" on any CI runner, including GitHub Actions, which sets CI=true for every job.
process.env.LARAVEL_BYPASS_ENV_CHECK = '1';

export default mergeConfig(viteConfig, defineConfig({
    test: {
        environment: 'happy-dom',
        globals: true,
        include: ['resources/js/**/*.test.ts'],
        setupFiles: ['resources/js/__tests__/setup.ts'],
    },
    resolve: {
        alias: {
            '@': resolve(import.meta.dirname, './resources/js'),
            '~': resolve(import.meta.dirname, './resources/images'),
        },
    },
}));
