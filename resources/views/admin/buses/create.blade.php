<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Nieuwe Bus Toevoegen') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        <div class="bg-gray-800 shadow-md rounded-lg p-6">
            <form method="POST" action="{{ route('admin.buses.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-white">Busnaam</label>
                    <input type="text" name="name" id="name" class="mt-1 block w-full p-2 rounded bg-gray-700 text-black" required>
                </div>

                <div>
                    <label for="capacity" class="block text-sm font-medium text-white">Capaciteit</label>
                    <input type="number" name="capacity" id="capacity" class="mt-1 block w-full p-2 rounded bg-gray-700 text-black" required>
                </div>

                <button type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded shadow-md">
                    Opslaan
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
