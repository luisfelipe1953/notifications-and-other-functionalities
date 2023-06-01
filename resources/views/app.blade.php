<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel Application</title>

    @vite(['resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=VT323&display=swap" rel="stylesheet">
   
    @vite('resources/css/app.css')
    @livewireStyles
</head>

<body class="max-w-6xl mx-auto bg-zinc-100">

    @yield('content')
    <div id="toast"></div>
    @auth
        @include('auth.userId')
    @endauth
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
    @yield('scripts')
    @livewireScripts
</body>

</html>
