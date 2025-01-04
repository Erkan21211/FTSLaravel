<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Beschikbare Busritten') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        <div class="bg-gray-800 shadow-md rounded-lg p-6">
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
                        <td class="p-4">{{ $busPlanning->festival->name }}</td>
                        <td class="p-4">{{ $busPlanning->bus->name }}</td>
                        <td class="p-4">{{ $busPlanning->departure_time }}</td>
                        <td class="p-4">€{{ number_format($busPlanning->cost_per_seat, 2) }}</td>
                        <td class="p-4">{{ $busPlanning->available_seats - $busPlanning->seats_filled }}</td>
                        <td class="p-4">
                            @if (($busPlanning->available_seats - $busPlanning->seats_filled) > 0)
                                <form method="POST" action="{{ route('reizen.book', $busPlanning->id) }}">
                                    @csrf
                                    <button type="submit"
                                            class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded shadow-md transition">
                                        Boek Nu
                                    </button>
                                </form>
                            @else
                                <span class="text-red-500 font-semibold">Volgeboekt</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
