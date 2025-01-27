<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Punten bewerken voor ') . $customer->first_name . ' ' . $customer->last_name }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        <div class="bg-white shadow-md rounded-lg p-6">
            <form method="POST" action="{{ route('admin.points.update', $customer->id) }}">
                @csrf
                @method('PUT')

                <label for="points" class="block text-sm font-medium text-gray-700">Punten</label>
                <input type="number" name="points" id="points" value="{{ $customer->points }}"
                       class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-blue-500 focus:ring-blue-500 sm:text-sm">

                <button type="submit"
                        class="mt-4 bg-blue-500 hover:bg-blue-600 text-black font-bold py-2 px-4 rounded shadow-md">
                    Punten Bijwerken
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
