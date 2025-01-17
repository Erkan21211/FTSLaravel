<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reisgeschiedenis van ') . $customer->first_name . ' ' . $customer->last_name }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h1 class="text-2xl font-bold mb-4">Reisgeschiedenis</h1>

            @if ($bookings->isEmpty())
                <p class="text-gray-600">Geen reisgeschiedenis beschikbaar voor deze klant.</p>
            @else
                <table class="w-full text-gray-800 border-collapse">
                    <thead>
                    <tr class="bg-gray-200">
                        <th class="border-b border-gray-300 p-4 text-left">Datum</th>
                        <th class="border-b border-gray-300 p-4 text-left">Festivalnaam</th>
                        <th class="border-b border-gray-300 p-4 text-left">Locatie</th>
                        <th class="border-b border-gray-300 p-4 text-left">Kosten</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($bookings as $booking)
                        <tr>
                            <td class="border-b border-gray-300 p-4">{{ $booking->booking_date->format('d-m-Y') }}</td>
                            <td class="border-b border-gray-300 p-4">{{ $booking->festival->name }}</td>
                            <td class="border-b border-gray-300 p-4">{{ $booking->festival->location }}</td>
                            <td class="border-b border-gray-300 p-4">€{{ number_format($booking->cost, 2) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout>
