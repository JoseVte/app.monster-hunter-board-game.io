import {resolve} from "path";
import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import {VitePWA} from "vite-plugin-pwa";

export default defineConfig({
    build: {
        manifest: 'manifest.json',
    },
    resolve: {
        alias: {
            '~': resolve(__dirname, './resources/images')
        }
    },
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            ssr: 'resources/js/ssr.js',
            refresh: true,
            alias: {
                '@': resolve(__dirname, './resources/js'),
            },
            appType: 'spa',
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        VitePWA({
            mode: 'development',
            injectRegister: 'auto',
            scope: '/',
            base: '/',
            registerType: 'autoUpdate',
            outDir: 'public',
            workbox: {
                globPatterns: ['**/*.{js,css,webp,jpg,png}'],
                navigateFallback: null,
                cleanupOutdatedCaches: false,
            },
            manifest: {
                id: "/",
                name: "Monster Hunter World: Board Game",
                short_name: "MH World: Board Game",
                icons: [
                    {
                        src: "/android-chrome-192x192.png",
                        sizes: "192x192",
                        type: "image/png"
                    },
                    {
                        src: "/android-chrome-512x512.png",
                        sizes: "512x512",
                        type: "image/png",
                        purpose: "any"
                    },
                    {
                        src: "/android-chrome-512x512.png",
                        sizes: "512x512",
                        type: "image/png",
                        purpose: "maskable"
                    }
                ],
                theme_color: "#333333",
                background_color: "#333333",
                start_url: "/",
                scope: "/",
                display: "standalone"
            }
        })
    ],
});
