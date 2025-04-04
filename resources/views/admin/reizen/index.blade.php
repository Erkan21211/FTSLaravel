<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Reizen Overzicht') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        <div class="bg-gray-800 shadow-md rounded-lg p-6">
            @if (session('success'))
                <div class="bg-green-500 text-white p-4 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Knoppen en formulier -->
            <div class="mb-6 flex gap-4">
                <!-- Nieuwe Reis Toevoegen -->
                <a href="{{ route('admin.reizen.create') }}"
                   class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded shadow-md transition">
                    Nieuwe Reis Toevoegen
                </a>

                <!-- Nieuwe Bus Toevoegen -->
                <a href="{{ route('admin.buses.create') }}"
                   class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded shadow-md transition">
                    Nieuwe Bus Toevoegen
                </a>
            </div>

            <!-- Reizen Overzicht -->
            <div class="overflow-x-auto">
                <table class="w-full text-white border-collapse">
                    <thead>
                    <tr class="bg-gray-700 text-gray-300">
                        <th class="border-b border-gray-600 p-4 text-left">Festival</th>
                        <th class="border-b border-gray-600 p-4 text-left">Locatie</th>
                        <th class="border-b border-gray-600 p-4 text-left">Startdatum</th>
                        <th class="border-b border-gray-600 p-4 text-left">Einddatum</th>
                        <th class="border-b border-gray-600 p-4 text-left">Kosten</th>
                        <th class="border-b border-gray-600 p-4 text-left">Beschikbare Stoelen</th>
                        <th class="border-b border-gray-600 p-4 text-left">Bus</th>
                        <th class="border-b border-gray-600 p-4 text-left">Acties</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($busPlannings as $busPlanning)
                        <tr>
                            <td class="border-b border-gray-600 p-4">{{ $busPlanning->festival->name }}</td>
                            <td class="border-b border-gray-600 p-4">{{ $busPlanning->festival->location }}</td>
                            <td class="border-b border-gray-600 p-4">{{ \Carbon\Carbon::parse($busPlanning->festival->start_date)->format('d-m-Y') }}</td>
                            <td class="border-b border-gray-600 p-4">{{ \Carbon\Carbon::parse($busPlanning->festival->end_date)->format('d-m-Y') }}</td>

                            <td class="border-b border-gray-600 p-4">
                                €{{ number_format($busPlanning->cost_per_seat, 2) }}</td>
                            <td class="border-b border-gray-600 p-4">
                                {{ $busPlanning->available_seats - $busPlanning->seats_filled }}
                            </td>
                            <td class="border-b border-gray-600 p-4">{{ $busPlanning->bus->name }}
                                ({{ $busPlanning->bus->capacity }} zitplaatsen)
                            </td>
                            <td class="border-b border-gray-600 p-4">
                                <a href="{{ route('admin.reizen.edit', $busPlanning->festival->id) }}"
                                   class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded shadow-md transition">
                                    Bewerken
                                </a>
                                <form method="POST" action="{{ route('admin.reizen.destroy', $busPlanning->festival->id) }}"
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded shadow-md transition">
                                        Verwijderen
                                    </button>
                                </form>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
