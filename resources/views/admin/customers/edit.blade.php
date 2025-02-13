<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Klant Bewerken') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl text-white font-bold mb-4">Klant Bewerken</h1>

                    <form method="POST" action="{{ route('admin.customers.update', $customer) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-white">Naam</label>
                            <input type="text" name="first_name" id="first_name" value="{{ $customer->first_name }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-white">Achternaam</label>
                            <input type="text" name="last_name" id="last_name" value="{{ $customer->last_name }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-white">E-mail</label>
                            <input type="email" name="email" id="email" value="{{ $customer->email }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>

                        <div class="mb-4">
                            <label for="phone_number" class="block text-sm font-medium text-white">Telefoonnummer</label>
                            <input type="text" name="phone_number" id="phone_number" value="{{ $customer->phone_number }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>

                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md">Opslaan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
