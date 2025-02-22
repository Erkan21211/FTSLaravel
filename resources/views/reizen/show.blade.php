<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Reis naar ' . $festival->name) }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        <!-- Extra container met een donkere achtergrond -->
        <div class="bg-gray-800 p-6 rounded-lg shadow-xl">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($busPlannings as $busPlanning)
                    <div class="bg-gray-700 shadow-2xl rounded-lg p-6">
                        <h3 class="text-lg text-white font-bold mb-2">Reisdetails</h3>
                        <p class="text-gray-300"><strong>Vertrektijd:</strong> {{ $busPlanning->departure_time }}</p>
                        <p class="text-gray-300"><strong>Locatie:</strong> {{ $busPlanning->departure_location }}</p>
                        <p class="text-gray-300"><strong>Beschikbare Stoelen:</strong> {{ $busPlanning->available_seats - $busPlanning->seats_filled }}</p>
                        <p class="text-gray-300"><strong>Kosten:</strong> €{{ number_format($busPlanning->cost_per_seat, 2) }}</p>
                        <p class="text-gray-300">Beschrijving van de reis is momenteel niet beschikbaar.</p>
                        <form method="POST" action="{{ route('reizen.book', $busPlanning->id) }}" class="mt-4">
                            @csrf
                            <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white font-bold py-2 px-4 rounded shadow-lg mb-2">
                                Nu Boeken
                            </button>
                        </form>
                        @if ($user && $user->points >= $busPlanning->cost_per_seat)
                            <form method="POST" action="{{ route('reizen.redeem', $busPlanning->id) }}">
                                @csrf
                                <button type="submit" class="bg-green-600 hover:bg-green-500 text-white font-bold py-2 px-4 rounded shadow-lg">
                                    Betaal met punten ({{ $busPlanning->cost_per_seat }} punten)
                                </button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
