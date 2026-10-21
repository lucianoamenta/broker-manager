<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50 text-slate-800 antialiased selection:bg-sky-500 selection:text-white">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Broker Manager — Plataforma Integral de Seguros')</title>
    <meta name="description" content="@yield('meta_description', 'Gestión inteligente, cotizaciones multi-compañía, emisión y administración omnicanal de pólizas para brokers y asesores de seguros.')">

    {{-- Google Fonts: IBM Plex Sans --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Styles & Scripts --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="min-h-full flex flex-col bg-slate-50 font-sans text-slate-800">
    {{-- Navbar Global --}}
    @include('layouts.navigation')

    {{-- Main Content --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- Footer Global --}}
    @include('layouts.footer')

    @stack('scripts')
</body>
</html>
