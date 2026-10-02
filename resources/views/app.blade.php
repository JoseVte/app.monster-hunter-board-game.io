<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <x-favicons />

        {{-- Before the static title, not after it. With SSR on, this prints the
             page's own `<title>` (and anything else a page puts in `<Head>`), and
             a crawler reads the first title in the document: left below the
             static one, every page was indexed as the bare app name. With SSR off
             or failing it prints nothing and the static title is the only one. --}}
        @inertiaHead
        <title inertia>{{ config('app.name', 'Laravel') }}</title>
        <link rel="canonical" href="" />
        <meta name="description" content="{{ __('Track your Monster Hunter World: The Board Game campaigns. Register hunters, log hunts, craft weapons and armour, and look anything up in the wiki.') }}" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <script>
            // On page load or when changing themes, best to add inline in `head` to avoid FOUC
            if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark')
            }
        </script>
        @routes
        @vite(['resources/js/app.ts', "resources/js/Pages/{$page['component']}.vue"])
    </head>
    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
        @inertia
    </body>
</html>
