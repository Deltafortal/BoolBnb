<!doctype html>
<html lang="it">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('img/logo.png') }}">

    {{-- Title --}}
    <title>{{ config('app.name', 'Boolbnb') }} - @yield('title')</title>

    {{-- Fontawesome --}}
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css'
        integrity='sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=='
        crossorigin='anonymous' />
    {{-- cdn --}}
    @yield('cdn')

    @vite(['resources/js/app.js'])

    <style>
        body {
            display: none
        }
    </style>
</head>

<body>
    <div id="app">
        {{-- Header --}}
        @include('includes.header')

        {{-- Main --}}
        <main>
            @yield('main')
        </main>

        {{-- Footer --}}
        @include('includes.footer')

    </div>
    @yield('scripts')
</body>

</html>
