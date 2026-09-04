@props([
    'title' => config('app.name', 'VIVIO'),
    'description' => '',
    'lang' => 'ar',
    'dir' => 'rtl',
])

<!DOCTYPE html>
<html lang="{{ $lang }}" dir="{{ $dir }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $description }}">

    <meta name="theme-color" content="#05080D">
    <title>{{ $title }}</title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    @fonts

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    @livewireStyles
</head>
<body class="vivio-site antialiased overflow-x-hidden">

    <div class="vivio-grain" aria-hidden="true"></div>

    {{-- Main content --}}
    <div class="relative z-10">
        {{-- Navigation --}}
        <x-navigation.navbar />

        {{-- Page content --}}
        <main>
            {{ $slot }}
        </main>

        {{-- Footer --}}
        <x-layout.footer />
    </div>

    @livewireScripts
    @stack('scripts')
</body>
</html>
