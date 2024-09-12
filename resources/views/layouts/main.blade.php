<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>PT Jasa Raharja - {{ $title }}</title>
        <link rel="icon" href="{{ asset('assets/Logo/Jasa Raharja Logo Utama.png') }}">

        {{-- CDN --}}
        <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
        <script src="https://kit.fontawesome.com/d7833bfda5.js" crossorigin="anonymous"></script>

        @vite('resources/css/app.css')
    </head>
    <body class="font-sans antialiased">
        @include('partials.sidebar')
        @yield('container')
        @include('partials.footer')
    </body>
</html>