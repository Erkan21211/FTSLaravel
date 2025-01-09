<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Klanten Overzicht') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-4">Klanten Overzicht</h1>

                    <table class="table-auto w-full border">
                        <thead class="bg-gray-200">
                        <tr>
                            <th class="border px-4 py-2">Naam</th>
                            <th class="border px-4 py-2">E-mail</th>
                            <th class="border px-4 py-2">Telefoon</th>
                            <th class="border px-4 py-2">Acties</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($customers as $customer)
                            <tr>
                                <td class="border px-4 py-2">{{ $customer->first_name }}</td>
                                <td class="border px-4 py-2">{{ $customer->email }}</td>
                                <td class="border px-4 py-2">{{ $customer->phone_number }}</td>
                                <td class="border px-4 py-2">
                                    <a href="{{ route('admin.customers.edit', $customer) }}" class="text-blue-600 hover:underline">Bewerken</a>
                                    <form method="POST" action="{{ route('admin.customers.destroy', $customer) }}" class="inline-block" onsubmit="return confirm('Weet je zeker dat je deze klant wilt verwijderen?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Verwijderen</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
