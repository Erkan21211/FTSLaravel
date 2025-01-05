<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    <!-- Styles / Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-..." crossorigin="anonymous">
</head>
<body class="font-sans antialiased dark:bg-black dark:text-white/50">
<header class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="text-xl font-semibold text-gray-800">FTS</div>
            <nav class="space-x-4">
                <a href="#" class="text-gray-600 hover:text-gray-800">Home</a>
                <a href="#" class="text-gray-600 hover:text-gray-800">Reizen</a>
                <a href="#" class="text-gray-600 hover:text-gray-800">Contact</a>
                @if (Auth::check())
                    <a href="{{ route('profile') }}" class="text-gray-600 hover:text-gray-800">Profiel</a>
                    <a href="{{ route('logout') }}" class="text-gray-600 hover:text-gray-800"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @else
                    <a href="{{ route('register') }}" class="text-gray-600 hover:text-gray-800">Register</a>
                @endif
            </nav>
        </div>
    </div>
</header>
<main class="flex justify-center items-center min-h-screen bg-gray-100">
    <div class="text-center bg-white p-10 rounded shadow-lg max-w-lg w-full">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">WELKOM BIJ</h1>
        <h2 class="text-2xl text-gray-700 mb-6">Festival Travel System</h2>
        <p class="text-gray-600 mb-8">
            Plan je reis en geniet van een zorgeloze festivalervaring.<br>
            Ontdek reizen en beheer je boekingen eenvoudig!
        </p>
        <div class="space-x-4">
            <a href="#"
               class="bg-gray-800 text-white px-6 py-2 rounded hover:bg-gray-900">
                Beschikbare Reizen
            </a>
            <a href="#"
               class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                Account Aanmaken
            </a>
        </div>
    </div>
</main>
</body>
</html>
