<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight text-center">
            Reis naar {{ $festival->name }}
        </h2>
    </x-slot>

    <div class="flex justify-center items-center min-h-screen">
        @foreach ($busPlannings as $busPlanning)
            <div class="bg-white rounded-lg shadow-md p-8 w-96 text-center mb-6">
                <!-- Reisdetails -->
                <h3 class="text-gray-800 font-bold text-lg mb-4">Reisdetails</h3>
                <p class="text-gray-600"><strong>Vertrektijd:</strong> {{ $busPlanning->departure_time }}</p>
                <p class="text-gray-600"><strong>Locatie:</strong> {{ $busPlanning->departure_location }}</p>
                <p class="text-gray-600"><strong>Beschikbare Stoelen:</strong> {{ $busPlanning->available_seats - $busPlanning->seats_filled }}</p>
                <p class="text-gray-600"><strong>Kosten:</strong> €{{ number_format($busPlanning->cost_per_seat, 2) }}</p>

                <!-- Beschrijving -->
                <p class="text-gray-500 mt-4">
                    {{ $festival->description ?? 'Beschrijving van de reis is momenteel niet beschikbaar.' }}
                </p>

                <!-- Knop om te boeken -->
                @if (($busPlanning->available_seats - $busPlanning->seats_filled) > 0)
                    <form method="POST" action="{{ route('reizen.book', $busPlanning->id) }}" class="mt-6">
                        @csrf
                        <button type="submit" class="bg-blue-500 hover:bg-black-200 text-black font-bold py-2 px-4 rounded w-full">
                            Nu Boeken
                        </button>
                    </form>
                @else
                    <p class="text-red-500 mt-6">Deze reis is volgeboekt.</p>
                @endif
            </div>
        @endforeach
    </div>
</x-app-layout>
