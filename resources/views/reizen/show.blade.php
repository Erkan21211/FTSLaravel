<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ $festival->name }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        <div class="bg-gray-800 shadow-md rounded-lg p-6">
            <!-- Festival Details -->
            <h3 class="text-lg text-white font-bold mb-4">Festivaldetails</h3>
            <p class="text-white"><strong>Locatie:</strong> {{ $festival->location }}</p>
            <p class="text-white"><strong>Startdatum:</strong> {{ $festival->start_date }}</p>
            <p class="text-white"><strong>Einddatum:</strong> {{ $festival->end_date }}</p>

            <!-- Beschikbare Bussen -->
            <h4 class="text-lg text-white font-bold mt-6">Beschikbare Bussen</h4>

            @if ($busPlanning->isEmpty())
                <p class="text-gray-400 mt-4">Er zijn momenteel geen busritten beschikbaar voor dit festival.</p>
            @else
                <table class="w-full text-white mt-4 border-collapse">
                    <thead>
                    <tr>
                        <th class="border-b border-gray-600 p-2 text-left">Busnummer</th>
                        <th class="border-b border-gray-600 p-2 text-left">Capaciteit</th>
                        <th class="border-b border-gray-600 p-2 text-left">Beschikbare Stoelen</th>
                        <th class="border-b border-gray-600 p-2 text-left">Kosten per Stoel</th>
                        <th class="border-b border-gray-600 p-2 text-left">Actie</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($busPlanning as $planning)
                        <tr>
                            <td class="p-2">{{ $planning->bus->id }}</td> <!-- Busnummer -->
                            <td class="p-2">{{ $planning->bus->capacity }}</td>
                            <td class="p-2">{{ $planning->available_seats - $planning->seats_filled }}</td>
                            <td class="p-2">€{{ number_format($planning->cost_per_seat, 2) }}</td>
                            <td class="p-2">
                                @if ($planning->available_seats > $planning->seats_filled)
                                    <form method="POST" action="{{ route('reizen.book', $planning->id) }}">
                                        @csrf
                                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded shadow-md transition">
                                            Boek deze reis
                                        </button>
                                    </form>
                                @else
                                    <span class="text-red-500">Volgeboekt</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    @if ($busPlanning->isEmpty())
                        <p class="text-white">Er zijn geen busritten beschikbaar voor dit festival.</p>
                    @else
                        <table class="w-full text-white mt-4">
                            <!-- Busritten tabel -->
                        </table>
                    @endif
                    </tbody>
                </table>
            @endif

            <!-- Terugknop -->
            <div class="mt-6">
                <a href="{{ route('reizen.index') }}" class="bg-gray-700 hover:bg-gray-800 text-white font-bold py-2 px-4 rounded shadow-md transition">
                    Terug naar Overzicht
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
