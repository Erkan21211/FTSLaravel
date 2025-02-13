<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Welkom bij Festival Travel System') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        <div class="bg-gray-800 shadow-md rounded-lg p-6 text-center">
            <h1 class="text-2xl text-white font-bold mb-4">Welkom bij Festival Travel System</h1>
            <p class="text-white mb-6">Plan je reis en geniet van een zorgeloze festivalervaring. Ontdek reizen en beheer je boekingen eenvoudig!</p>

            <div class="flex justify-center gap-4 mt-8">
                <!-- Controleer of de gebruiker is ingelogd -->
                @auth
                    <!-- Authenticated: Link naar private reizen -->
                    <a href="{{ route('reizen.index') }}"
                       class="bg-sky-500 hover:bg-sky-600 text-white font-bold py-2 px-4 rounded">
                        Beschikbare Reizen
                    </a>
                @else
                    <!-- Gast: Link naar public reizen -->
                    <a href="{{ route('reizen.guest') }}"
                       class="bg-sky-500 hover:bg-sky-600 text-white font-bold py-2 px-4 rounded">
                        Beschikbare Reizen
                    </a>
                @endauth

                <!-- Toon de registratielink alleen als de gebruiker niet is ingelogd -->
                @guest
                    <a href="{{ route('register') }}"
                       class="bg-sky-500 hover:bg-sky-600 text-white font-bold py-2 px-4 rounded">
                        Account aanmaken
                    </a>
                @endguest
            </div>
        </div>
    </div>
</x-app-layout>
