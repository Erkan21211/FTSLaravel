<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ $festival->name }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        <div class="bg-gray-800 shadow-md rounded-lg p-6">
            <h3 class="text-lg text-white font-bold mb-4">Details</h3>
            <p class="text-white"><strong>Locatie:</strong> {{ $festival->location }}</p>
            <p class="text-white"><strong>Startdatum:</strong> {{ $festival->start_date }}</p>
            <p class="text-white"><strong>Einddatum:</strong> {{ $festival->end_date }}</p>

            <h4 class="text-lg text-white font-bold mt-6">Beschikbare Bussen:</h4>
            <table class="w-full text-white mt-4">
                <thead>
                <tr>
                    <th class="border-b border-gray-600 p-2 text-left">Busnummer</th>
                    <th class="border-b border-gray-600 p-2 text-left">Capaciteit</th>
                    <th class="border-b border-gray-600 p-2 text-left">Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($busPlanning as $planning)
                    <tr>
                        <td class="p-2">{{ $planning->bus->bus_number }}</td>
                        <td class="p-2">{{ $planning->bus->capacity }}</td>
                        <td class="p-2">{{ ucfirst($planning->bus->status) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="mt-6">
                <a href="{{ route('bookings.create', $festival->id) }}"
                   class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded shadow-md transition">
                    Boek deze reis
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
