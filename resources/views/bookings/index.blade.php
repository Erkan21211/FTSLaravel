<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-white text-xl leading-tight">
            {{ __('Mijn Boekingen') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        @if (session('success'))
            <div class="p-4 mb-4 text-green-600 bg-green-100 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="p-6">
                @if($bookings->isEmpty())
                    <p class="text-gray-600">{{ __('Je hebt nog geen boekingen.') }}</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full table-auto border-collapse">
                            <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">Festivalnaam</th>
                                <th class="py-3 px-6 text-left">Datum en Tijd</th>
                                <th class="py-3 px-6 text-right">Kosten</th>
                                <th class="py-3 px-6 text-center">Status</th>
                                <th class="py-3 px-6 text-center">Actie</th>
                            </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($bookings as $booking)
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="py-3 px-6 text-left whitespace-nowrap">{{ $booking->festival->name }}</td>
                                    <td class="py-3 px-6 text-left">{{ $booking->booking_date }}</td>
                                    <td class="py-3 px-6 text-right">€{{ number_format($booking->cost, 2) }}</td>
                                    <td class="py-3 px-6 text-center">
                                            <span class="py-1 px-3 rounded-full text-xs font-medium
                                                {{ $booking->status === 'actief' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        @if ($booking->status === 'actief')
                                            <form method="POST" action="{{ route('bookings.cancel', $booking->id) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        class="bg-red-500 text-black py-1 px-3 rounded text-xs font-medium hover:bg-red-600">
                                                    Annuleren
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-500 text-xs">Niet beschikbaar</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('dashboard') }}" class="text-blue-500 hover:underline">
                {{ __('Terug naar Dashboard') }}
            </a>
        </div>
    </div>
</x-app-layout>
