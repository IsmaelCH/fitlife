<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'FitLife')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100 antialiased font-light transition-colors duration-300">
@include('partials.nav')
<main class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">
    @if(session('success'))
        <div class="bg-white dark:bg-gray-800 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 px-4 py-3 mb-6 rounded-lg text-sm" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @yield('content')
</main>
</body>
</html>
