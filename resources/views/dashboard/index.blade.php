<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            @if(auth()->user()->is_admin)
                {{ __('Admin Dashboard') }}
            @else
                {{ __('Dashboard van ') . auth()->user()->first_name . ' ' . auth()->user()->last_name }}
            @endif
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        <div class="bg-gray-800 shadow-md rounded-lg p-6">
            @if(auth()->user()->is_admin)
                <!-- Admin Dashboard Content -->
                <h1 class="text-2xl text-white font-bold mb-4">Welkom, {{ auth()->user()->first_name }}</h1>
                <p class="text-white">Hier kunt u klanten, reizen en het puntensysteem beheren.</p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                    <a href="{{ route('admin.customers.index') }}"
                       class="bg-blue-500 hover:bg-blue-600 text-black font-bold py-4 px-6 rounded text-center shadow-md">
                        Klanten Beheren
                    </a>
                    <a href="{{ route('admin.reizen.index') }}"
                       class="bg-blue-500 hover:bg-blue-600 text-black font-bold py-4 px-6 rounded text-center shadow-md">
                        Reizen Beheren
                    </a>
                    <a href="{{ route('admin.points.index') }}"
                       class="bg-blue-500 hover:bg-blue-600 text-black font-bold py-4 px-6 rounded text-center shadow-md">
                        Punten Beheren
                    </a>
                </div>
            @else
                <!-- Normale gebruiker Dashboard Content -->
                <div class="flex gap-4 mb-6">
                    <a href="{{ route('bookings.index') }}"
                       class="bg-blue-500 hover:bg-blue-600 text-black font-bold py-2 px-4 rounded shadow-md transition">
                        Mijn Boekingen
                    </a>
                    <a href="{{ route('reizen.index') }}"
                       class="bg-blue-500 hover:bg-blue-600 text-black font-bold py-2 px-4 rounded shadow-md transition">
                        Nu boeken
                    </a>
                </div>
                <div class="bg-gray-800 text-white rounded-lg p-6 shadow-md mb-6">
                    <h3 class="text-lg font-bold">Puntensaldo</h3>
                    <p>Je hebt <strong>{{ auth()->user()->points }}</strong> punten.</p>
                </div>

                <!-- zoek functie -->
                <div class="mb-6">
                    <form method="GET" action="{{ route('dashboard') }}">
                        <input type="text" name="query" placeholder="Zoek reizen..."
                               class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none text-gray-800"
                               value="{{ request('query') }}">
                        @if (isset($searchResults))
                            <div class="bg-gray-950 shadow-md rounded-lg p-6 mt-6">
                                @if ($searchResults->isNotEmpty())
                                    <div class="overflow-x-auto">
                                        <table class="w-full text-gray-300">
                                            <thead>
                                            <tr>
                                                <th class="border-b text-white border-gray-600 p-2 text-left">Festivalnaam</th>
                                                <th class="border-b text-white border-gray-600 p-2 text-left">Locatie</th>
                                                <th class="border-b text-white border-gray-600 p-2 text-left">Startdatum</th>
                                                <th class="border-b text-white border-gray-600 p-2 text-left">Einddatum</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($searchResults as $result)
                                                <tr>
                                                    <td class="p-2 text-white" >{{ $result->name }}</td>
                                                    <td class="p-2 text-white">{{ $result->location }}</td>
                                                    <td class="border-b border-gray-600 p-4">{{ \Carbon\Carbon::parse($result->start_date)->format('d-m-Y') }}</td>
                                                    <td class="border-b border-gray-600 p-4">{{ \Carbon\Carbon::parse($result->end_date)->format('d-m-Y') }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-gray-400">Geen resultaten gevonden voor "{{ request('query') }}".</p>
                                @endif
                            </div>
                        @endif
                        <button type="submit"
                                class="mt-3 bg-blue-500 hover:bg-blue-600 text-black font-bold py-2 px-4 rounded shadow-md transition">
                            Zoek
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
