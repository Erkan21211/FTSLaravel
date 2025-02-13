<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Contact') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-gray-800 shadow-md rounded-lg p-6">
            @if (session('success'))
                <div class="bg-green-200 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <h1 class="text-2xl text-white font-bold mb-4">Neem Contact Op</h1>
            <p class="mb-6 text-white">Heeft u vragen of opmerkingen? Vul het onderstaande formulier in en wij nemen zo snel mogelijk contact met u op.</p>

            <form method="POST" action="{{ route('contact.submit') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-white">Naam</label>
                    <input type="text" name="name" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-white">E-mail</label>
                    <input type="email" name="email" id="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                </div>

                <div>
                    <label for="message" class="block text-sm font-medium text-white">Bericht</label>
                    <textarea name="message" id="message" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required></textarea>
                </div>

                <div>
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded-md shadow-md">
                        Verzenden
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
