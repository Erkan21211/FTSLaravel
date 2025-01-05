<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Reis naar ') . $booking->busPlanning->festival->name }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 py-12">
        <div class="bg-gray-800 shadow-md rounded-lg p-6">
            <h3 class="text-lg text-white font-bold mb-4">Reisdetails</h3>

            <p class="text-white"><strong>Festival:</strong> {{ $booking->busPlanning->festival->name }}</p>
            <p class="text-white"><strong>Vertrektijd:</strong> {{ $booking->busPlanning->departure_time }}</p>
            <p class="text-white"><strong>Locatie:</strong> {{ $booking->busPlanning->departure_location }}</p>
            <p class="text-white"><strong>Kosten:</strong> €{{ number_format($booking->cost, 2) }}</p>
            <p class="text-white"><strong>Status:</strong> {{ ucfirst($booking->status) }}</p>

            <div class="mt-6">
                <a href="{{ route('bookings.index') }}" class="bg-gray-700 hover:bg-gray-800 text-white font-bold py-2 px-4 rounded shadow-md transition">
                    Terug naar boekingen
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
