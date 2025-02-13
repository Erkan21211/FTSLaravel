<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nieuwe Klant Toevoegen') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        <div class="bg-gray-800 shadow-md rounded-lg p-6">
            <h1 class="text-2xl text-white font-bold mb-4">Nieuwe Klant Toevoegen</h1>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <strong class="font-bold">Oeps!</strong>
                    <span class="block sm:inline">Er waren problemen met je invoer.</span>
                    <ul class="mt-2 list-disc pl-5 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <form method="POST" action="{{ route('admin.customers.store') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="first_name" class="block text-sm font-medium text-white">Voornaam</label>
                    <input type="text" name="first_name" id="first_name" required
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="last_name" class="block text-sm font-medium text-white">Achternaam</label>
                    <input type="text" name="last_name" id="last_name" required
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-white">E-mail</label>
                    <input type="email" name="email" id="email" required
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="phone_number" class="block text-sm font-medium text-white">Telefoonnummer</label>
                    <input type="text" name="phone_number" id="phone_number"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-white">Wachtwoord</label>
                    <input type="password" name="password" id="password" required
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-black font-bold py-2 px-4 rounded shadow-md transition">
                    Toevoegen
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
