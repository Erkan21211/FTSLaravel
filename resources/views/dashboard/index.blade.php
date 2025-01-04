<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Dashboard van ') . $user->first_name . ' ' . $user->last_name }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        <div class="bg-gray-800 shadow-md rounded-lg p-6">
            <!-- Knoppen voor navigatie -->
            <div class="mb-6 flex gap-4">
                <a href="{{ route('bookings.index') }}"
                   class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded shadow-md transition">
                    Mijn Boekingen
                </a>
                <a href="{{ route('reizen.index') }}"
                   class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded shadow-md transition">
                    Nu boeken
                </a>
            </div>

            <!-- Zoekfunctie -->
            <div class="mb-6">
                <form method="GET" action="{{ route('dashboard') }}">
                    <input type="text" name="query" placeholder="Zoek reizen..."
                           class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none text-gray-800"
                           value="{{ request('query') }}">
                    <!-- Zoekresultaten -->
                    @if (isset($searchResults))
                        <div class="bg-gray-700 shadow-md rounded-lg p-6 mt-6">
                            @if ($searchResults->isNotEmpty())
                                <table class="w-full text-gray-300">
                                    <thead>
                                    <tr>
                                        <th class="border-b border-gray-600 p-2 text-left">Festivalnaam</th>
                                        <th class="border-b border-gray-600 p-2 text-left">Locatie</th>
                                        <th class="border-b border-gray-600 p-2 text-left">Startdatum</th>
                                        <th class="border-b border-gray-600 p-2 text-left">Einddatum</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($searchResults as $result)
                                        <tr>
                                            <td class="p-2">{{ $result->name }}</td>
                                            <td class="p-2">{{ $result->location }}</td>
                                            <td class="p-2">{{ $result->start_date }}</td>
                                            <td class="p-2">{{ $result->end_date }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p class="text-gray-400">Geen resultaten gevonden voor "{{ request('query') }}".</p>
                            @endif
                        </div>
                    @endif
                    <button type="submit"
                            class="mt-3 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded shadow-md transition">
                        Zoek
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
