<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Automatic Shifting Bank BTPN')</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: rgba(0, 40, 67, 1);
            --secondary: rgba(237, 139, 0, 1);
            --based-50: rgba(255, 255, 255, 1);
            --neutral-600: rgba(93, 93, 93, 1);
            --secondary-orange800: rgba(161, 56, 11, 1);
        }

        body {
            font-family: 'Montserrat', sans-serif;
            min-height: 100vh;
        }
    </style>

    <!-- Page Specific Styles -->
    @stack('styles')
</head>

<body class="flex flex-col min-h-screen">
    <!-- Page Content -->
    @yield('content')

    <!-- Common Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>

    <!-- Page Specific Scripts -->
    @stack('scripts')
</body>

</html>