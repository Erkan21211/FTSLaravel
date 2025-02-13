<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reisgeschiedenis van ') . $customer->first_name . ' ' . $customer->last_name }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        <div class="bg-gray-800 shadow-md rounded-lg p-6">
            <h1 class="text-2xl text-white font-bold mb-4">Reisgeschiedenis</h1>

            @if ($bookings->isEmpty())
                <p class="text-gray-600">Geen reisgeschiedenis beschikbaar voor deze klant.</p>
            @else
                <table class="w-full text-gray-800 border-collapse">
                    <thead>
                    <tr class="bg-gray-700 text-gray-300">
                        <th class="border-b border-gray-300 p-4 text-left">Datum</th>
                        <th class="border-b border-gray-300 p-4 text-left">Festivalnaam</th>
                        <th class="border-b border-gray-300 p-4 text-left">Locatie</th>
                        <th class="border-b border-gray-300 p-4 text-left">Kosten</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($bookings as $booking)
                        <tr class="hover:bg-gray-700 transition">
                            <td class="border-b border-gray-600 p-4 text-white">{{ $booking->booking_date->format('d-m-Y') }}</td>
                            <td class="border-b border-gray-600 p-4 text-white">{{ $booking->festival->name }}</td>
                            <td class="border-b border-gray-600 p-4 text-white">{{ $booking->festival->location }}</td>
                            <td class="border-b border-gray-600 p-4 text-white">€{{ number_format($booking->cost, 2) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout>
