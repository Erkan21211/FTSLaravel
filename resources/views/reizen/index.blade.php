<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Beschikbare Busritten naar festivals') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        <div class="bg-gray-800 shadow-md rounded-lg p-6">
            <!-- Responsive Table Wrapper -->
            <div class="overflow-x-auto">
                <table class="w-full text-gray-300 border-collapse">
                    <thead>
                    <tr class="bg-gray-700 text-white">
                        <th class="border-b border-gray-600 p-4 text-left">Festival</th>
                        <th class="border-b border-gray-600 p-4 text-left">Bus</th>
                        <th class="border-b border-gray-600 p-4 text-left">Vertrektijd</th>
                        <th class="border-b border-gray-600 p-4 text-left">Kosten</th>
                        <th class="border-b border-gray-600 p-4 text-left">Beschikbare Stoelen</th>
                        <th class="border-b border-gray-600 p-4 text-left">Actie</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($busPlannings as $busPlanning)
                        <tr class="hover:bg-gray-700 transition">
                            <td class="p-4">{{ $busPlanning->festival->name ?? 'Festival onbekend' }}</td>
                            <td class="p-4">{{ $busPlanning->bus->name ?? 'Bus onbekend' }}</td>
                            <td class="p-4">{{ $busPlanning->departure_time }}</td>
                            <td class="p-4">€{{ number_format($busPlanning->cost_per_seat, 2) }}</td>
                            <td class="p-4">{{ $busPlanning->available_seats - $busPlanning->seats_filled }}</td>
                            <td class="p-4">
                                @if ($busPlanning->festival)
                                    <a href="{{ route('reizen.show', $busPlanning->festival->id) }}"
                                       class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow-md transition">
                                        Bekijken
                                    </a>
                                @else
                                    <span class="text-gray-500">Niet beschikbaar</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
