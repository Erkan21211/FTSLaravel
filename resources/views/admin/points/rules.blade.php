<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Puntenregels Beheren') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        <div class="bg-white shadow-md rounded-lg p-6">
            <form method="POST" action="{{ route('admin.points.rules.update') }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="earn_points_per_booking" class="block text-sm font-medium text-gray-700">
                        Punten per Boeking
                    </label>
                    <input type="number" name="earn_points_per_booking" id="earn_points_per_booking"
                           value="{{ $rules['earn_points_per_booking'] }}"
                           class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:ring focus:ring-blue-500">
                </div>

                <div class="mb-4">
                    <label for="redeem_points_discount" class="block text-sm font-medium text-gray-700">
                        Korting per Punt
                    </label>
                    <input type="number" name="redeem_points_discount" id="redeem_points_discount"
                           value="{{ $rules['redeem_points_discount'] }}"
                           class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:ring focus:ring-blue-500">
                </div>

                <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded shadow-md">
                    Regels Bijwerken
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
