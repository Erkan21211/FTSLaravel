<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-white text-gray-800 leading-tight">
            {{ __('Klanten Overzicht') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        <div class="bg-gray-800 shadow-md rounded-lg p-6">
            @if (session('success'))
                <div class="bg-green-500 text-white p-4 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Knop om een nieuwe klant toe te voegen -->
            <div class="mb-6">
                <a href="{{ route('admin.customers.create') }}"
                   class="bg-sky-500 text-white font-bold py-2 px-4 rounded shadow-md transition hover:bg-sky-600">
                    Nieuwe Klant Toevoegen
                </a>
            </div>


            <div class="overflow-x-auto">
                <table class="w-full text-white border-collapse">
                    <thead>
                    <tr class="bg-gray-700 text-gray-300">
                        <th class="border-b border-gray-600 p-4 text-left">Naam</th>
                        <th class="border-b border-gray-600 p-4 text-left">E-mail</th>
                        <th class="border-b border-gray-600 p-4 text-left">Telefoon</th>
                        <th class="border-b border-gray-600 p-4 text-left">Acties</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($customers as $customer)
                        <tr class="hover:bg-gray-700 transition">
                            <td class="border-b border-gray-600 p-4 truncate">{{ $customer->first_name . ' ' . $customer->last_name }}</td>
                            <td class="border-b border-gray-600 p-4 truncate">{{ $customer->email }}</td>
                            <td class="border-b border-gray-600 p-4 truncate">{{ $customer->phone_number }}</td>
                            <td class="border-b border-gray-600 p-2 whitespace-nowrap space-x-1">
                                <!-- Bewerken knop -->
                                <a href="{{ route('admin.customers.edit', $customer->id) }}"
                                   class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-2 rounded text-sm shadow-md transition">
                                    Bewerken
                                </a>

                                <!-- Reisgeschiedenis knop -->
                                <a href="{{ route('admin.customers.history', $customer->id) }}"
                                   class="bg-green-500 hover:bg-green-600 text-white font-bold py-1 px-2 rounded text-sm shadow-md transition">
                                    Reisgeschiedenis
                                </a>

                                <!-- Verwijderen knop -->
                                <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-2 rounded text-sm shadow-md transition"
                                            onclick="return confirm('Weet je zeker dat je deze klant wilt verwijderen?')">
                                        Verwijderen
                                    </button>
                                </form>
                            </td>


                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
