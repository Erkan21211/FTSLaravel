<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profiel bewerken') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        <div class="bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                @if (session('success'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Points Display -->
                <div class="mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">
                        {{ __('Punten saldo') }}
                    </h3>
                    <p class="text-white">Je hebt <strong>{{ auth()->user()->points }}</strong> punten.</p>
                </div>

                <!-- Profile Update Form -->
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PATCH')

                    <!-- First Name -->
                    <div>
                        <x-input-label for="first_name" :value="__('Voornaam')"/>
                        <x-text-input id="first_name" type="text" name="first_name"
                                      value="{{ old('first_name', $customer->first_name) }}" required autofocus/>
                        <x-input-error :messages="$errors->get('first_name')" class="mt-2"/>
                    </div>

                    <!-- Last Name -->
                    <div class="mt-4">
                        <x-input-label for="last_name" :value="__('Achternaam')"/>
                        <x-text-input id="last_name" type="text" name="last_name"
                                      value="{{ old('last_name', $customer->last_name) }}" required/>
                        <x-input-error :messages="$errors->get('last_name')" class="mt-2"/>
                    </div>

                    <!-- Email -->
                    <div class="mt-4">
                        <x-input-label for="email" :value="__('E-mailadres')"/>
                        <x-text-input id="email" type="email" name="email" value="{{ old('email', $customer->email) }}"
                                      required/>
                        <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                    </div>

                    <!-- Phone Number -->
                    <div class="mt-4">
                        <x-input-label for="phone_number" :value="__('Telefoonnummer')"/>
                        <x-text-input id="phone_number" type="text" name="phone_number"
                                      value="{{ old('phone_number', $customer->phone_number) }}"/>
                        <x-input-error :messages="$errors->get('phone_number')" class="mt-2"/>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button>
                            {{ __('Bijwerken') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
