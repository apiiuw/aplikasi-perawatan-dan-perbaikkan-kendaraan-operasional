<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $title }} | PT Jasa Raharja</title>
        <link rel="icon" href="{{ asset('assets/Logo/Jasa Raharja Logo Utama.png') }}">

        {{-- CDN --}}
        <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
        <script src="https://kit.fontawesome.com/d7833bfda5.js" crossorigin="anonymous"></script>

        {{-- FONT --}}
        <link href="https://fonts.cdnfonts.com/css/neck-l-sans" rel="stylesheet">

        {{-- ICON --}}
        <script src="https://kit.fontawesome.com/d7833bfda5.js" crossorigin="anonymous"></script>

        {{-- flatpickr --}}
        <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

        @vite('resources/css/app.css')
    </head>
    <body class="font-sans antialiased">
        @include('partials.sidebar')
        @yield('container')
        @include('partials.footer')
    </body>
</html>