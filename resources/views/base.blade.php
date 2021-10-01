<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>RocketLog | Digital bullet journal with daily log and task migration</title>

        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">
        <meta name="msapplication-config" content="/browserconfig.xml" />
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="theme-color" content="#ffffff">

        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="@rocketlog">
        <meta name="twitter:creator" content="@jessarchercodes">
        <meta name="twitter:title" content="RocketLog - Unburden your mind.">
        <meta name="twitter:description" content="Is your todo list an unmanageable guilt-trip of things you thought were important but haven't done? We've been there too.">
        <meta name="twitter:image" content="https://rocketlog.app/images/rocketlog-twitter-card.png">

        <meta property="og:title" content="RocketLog - Unburden your mind." />
        <meta property="og:url" content="https://rocketlog.app" />
        <meta property="og:type" content="website" />
        <meta property="og:description" content="Is your todo list an unmanageable guilt-trip of things you thought were important but haven't done? We've been there too." />
        <meta property="og:image" content="https://rocketlog.app/images/rocketlog-twitter-card.png" />

        <!-- Fonts -->
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- Scripts -->
        @routes
        @stack('scripts')
        <script>
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark')
            } else {
                document.documentElement.classList.remove('dark')
            }
        </script>
        @if (config('app.url') === 'https://rocketlog.app')
            <script src="https://marmoset.rocketlog.app/script.js" data-spa="auto" data-site="PREDBIVK" defer></script>
        @endif
    </head>
    <body class="font-sans antialiased {{ $bodyClass ?? '' }}">
        @yield('body')
    </body>
</html>
