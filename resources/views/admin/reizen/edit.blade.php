<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Reis Bewerken') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        <div class="bg-gray-800 shadow-md rounded-lg p-6">
            <form method="POST" action="{{ route('admin.reizen.update', $festival->id) }}" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block text-sm font-medium text-white">Festivalnaam</label>
                    <input type="text" name="name" id="name" value="{{ $festival->name }}" class="mt-1 block w-full p-2 rounded bg-gray-700 text-black" required>
                </div>

                <div>
                    <label for="location" class="block text-sm font-medium text-white">Locatie</label>
                    <input type="text" name="location" id="location" value="{{ $festival->location }}" class="mt-1 block w-full p-2 rounded bg-gray-700 text-black" required>
                </div>

                <div>
                    <label for="start_date" class="block text-sm font-medium text-white">Startdatum</label>
                    <input type="date" name="start_date" id="start_date" value="{{ $festival->start_date }}" class="mt-1 block w-full p-2 rounded bg-gray-700 text-black" required>
                </div>

                <div>
                    <label for="end_date" class="block text-sm font-medium text-white">Einddatum</label>
                    <input type="date" name="end_date" id="end_date" value="{{ $festival->end_date }}" class="mt-1 block w-full p-2 rounded bg-gray-700 text-black" required>
                </div>

                <div>
                    <label for="cost_per_seat" class="block text-sm font-medium text-white">Kosten per stoel</label>
                    <input type="number" step="0.01" name="cost_per_seat" id="cost_per_seat" value="{{ $festival->busPlanning->cost_per_seat ?? '' }}" class="mt-1 block w-full p-2 rounded bg-gray-700 text-black" required>
                </div>

                <div>
                    <label for="available_seats" class="block text-sm font-medium text-white">Beschikbare stoelen</label>
                    <input type="number" name="available_seats" id="available_seats" value="{{ $festival->busPlanning->available_seats ?? '' }}" class="mt-1 block w-full p-2 rounded bg-gray-700 text-black" required>
                </div>

                <div>
                    <label for="bus_id" class="block text-sm font-medium text-white">Bus</label>
                    <select name="bus_id" id="bus_id" class="mt-1 block w-full p-2 rounded bg-gray-700 text-black" required>
                        @foreach(App\Models\Bus::all() as $bus)
                            <option value="{{ $bus->id }}" {{ ($festival->busPlanning->bus_id ?? '') == $bus->id ? 'selected' : '' }}>
                                {{ $bus->name }} ({{ $bus->capacity }} zitplaatsen)
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded shadow-md">
                    Opslaan
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
