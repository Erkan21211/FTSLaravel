<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Puntenbeheer Overzicht') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        <div class="bg-white shadow-md rounded-lg p-6">
            @if (session('success'))
                <div class="bg-green-500 text-green-50 p-4 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <table class="w-full text-gray-800 border-collapse">
                <thead>
                <tr class="bg-gray-200">
                    <th class="border-b border-gray-300 p-4 text-left">Naam</th>
                    <th class="border-b border-gray-300 p-4 text-left">E-mail</th>
                    <th class="border-b border-gray-300 p-4 text-left">Huidige Punten</th>
                    <th class="border-b border-gray-300 p-4 text-left">Acties</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($customers as $customer)
                    <tr>
                        <td class="border-b border-gray-300 p-4">
                            {{ $customer->first_name . ' ' . $customer->last_name }}
                        </td>
                        <td class="border-b border-gray-300 p-4">{{ $customer->email }}</td>
                        <td class="border-b border-gray-300 p-4">{{ $customer->points }}</td>
                        <td class="border-b border-gray-300 p-4">
                            <a href="{{ route('admin.points.edit', $customer->id) }}"
                               class="bg-blue-500 hover:bg-blue-600 text-black font-bold py-2 px-4 rounded shadow-md transition">
                                Bewerken
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
