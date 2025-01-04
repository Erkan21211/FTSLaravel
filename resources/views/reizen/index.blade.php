<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Beschikbare Reizen') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        <div class="bg-gray-800 shadow-md rounded-lg p-6">
            @if($festivals->isEmpty())
                <p class="text-gray-400">Er zijn momenteel geen beschikbare reizen.</p>
            @else
                <table class="w-full text-white">
                    <thead>
                    <tr>
                        <th class="border-b border-gray-600 p-2 text-left">Festivalnaam</th>
                        <th class="border-b border-gray-600 p-2 text-left">Locatie</th>
                        <th class="border-b border-gray-600 p-2 text-left">Startdatum</th>
                        <th class="border-b border-gray-600 p-2 text-left">Einddatum</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($festivals as $festival)
                        <tr>
                            <td class="p-2">{{ $festival->name }}</td>
                            <td class="p-2">{{ $festival->location }}</td>
                            <td class="p-2">{{ $festival->start_date }}</td>
                            <td class="p-2">{{ $festival->end_date }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout>
