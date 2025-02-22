<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Beschikbare Reizen') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        <div class="bg-gray-800 shadow-md rounded-lg p-6">
            <div class="overflow-x-auto">
                <table class="w-full bg-gray-800 text-gray-600 border-collapse">
                    <thead>
                    <tr class="bg-gray-600 text-white">
                        <th class="border-b border-gray-300 p-4 text-left">Festival</th>
                        <th class="border-b border-gray-300 p-4 text-left">Locatie</th>
                        <th class="border-b border-gray-300 p-4 text-left">Vertrektijd</th>
                        <th class="border-b border-gray-300 p-4 text-right">Kosten</th>
                        <th class="border-b border-gray-300 p-4 text-right">Beschikbare Stoelen</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($busPlannings as $busPlanning)
                        <tr class="">
                            <td class="p-4 text-white">{{ $busPlanning->festival->name }}</td>
                            <td class="p-4 text-white">{{ $busPlanning->festival->location }}</td>
                            <td class="p-4 text-white">{{ $busPlanning->departure_time }}</td>
                            <td class="p-4 text-white text-right">€{{ number_format($busPlanning->cost_per_seat, 2) }}</td>
                            <td class="p-4 text-white text-right">{{ $busPlanning->available_seats - $busPlanning->seats_filled }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            @if($busPlannings->isEmpty())
                <p class="text-gray-500 text-center mt-4">{{ __('Er zijn momenteel geen reizen beschikbaar.') }}</p>
            @endif
        </div>
    </div>
</x-app-layout>
