@php($themeColor = '#333333')

<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
<link rel="manifest" href="{{ asset('site.webmanifest') }}">
<link rel="mask-icon" href="{{ asset('safari-pinned-tab.svg') }}" color="{{ $themeColor }}">
<meta name="msapplication-TileColor" content="{{ $themeColor }}">
<meta name="theme-color" content="{{ $themeColor }}">

@env('production')
    <meta name="robots" content="index,follow">
@else
    <meta name="robots" content="noindex,nofollow">
@endenv
