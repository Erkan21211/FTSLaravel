<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Nieuwe Reis Toevoegen') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        <div class="bg-gray-800 shadow-md rounded-lg p-6">
            <form method="POST" action="{{ route('admin.reizen.store') }}" class="space-y-4">
                @csrf

                <!-- Festivalnaam -->
                <div>
                    <label for="name" class="block text-sm font-medium text-white">Festivalnaam</label>
                    <input type="text" name="name" id="name" class="mt-1 block w-full p-2 rounded bg-gray-700 text-black" required>
                </div>

                <!-- Locatie -->
                <div>
                    <label for="location" class="block text-sm font-medium text-white">Locatie</label>
                    <input type="text" name="location" id="location" class="mt-1 block w-full p-2 rounded bg-gray-700 text-black" required>
                </div>

                <!-- Startdatum -->
                <div>
                    <label for="start_date" class="block text-sm font-medium text-white">Startdatum</label>
                    <input type="date" name="start_date" id="start_date" class="mt-1 block w-full p-2 rounded bg-gray-700 text-black" required>
                </div>

                <!-- Einddatum -->
                <div>
                    <label for="end_date" class="block text-sm font-medium text-white">Einddatum</label>
                    <input type="date" name="end_date" id="end_date" class="mt-1 block w-full p-2 rounded bg-gray-700 text-black" required>
                </div>

                <!-- Kosten per stoel -->
                <div>
                    <label for="cost_per_seat" class="block text-sm font-medium text-white">Kosten per stoel</label>
                    <input type="number" step="0.01" name="cost_per_seat" id="cost_per_seat" class="mt-1 block w-full p-2 rounded bg-gray-700 text-black" required>
                </div>

                <!-- Beschikbare stoelen -->
                <div>
                    <label for="available_seats" class="block text-sm font-medium text-white">Beschikbare stoelen</label>
                    <input type="number" name="available_seats" id="available_seats" class="mt-1 block w-full p-2 rounded bg-gray-700 text-black" required>
                </div>

                <!-- Bus Selecteren -->
                <div>
                    <label for="bus_id" class="block text-sm font-medium text-white">Kies een Bus</label>
                    <select name="bus_id" id="bus_id" class="mt-1 block w-full p-2 rounded bg-gray-700 text-black" required>
                        @foreach ($buses as $bus)
                            <option value="{{ $bus->id }}">{{ $bus->name }} ({{ $bus->capacity }} stoelen)</option>
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
