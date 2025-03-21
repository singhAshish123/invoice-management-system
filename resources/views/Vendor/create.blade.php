<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Vendors') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('vendors.store') }}">
                    @csrf

                    <!-- Name -->
                    <div class="mt-4">
                        <x-input-label for="full_name" :value="__('Full Name')" />
                        <x-text-input id="full_name" class="block mt-1 w-full" type="text" name="full_name" :value="old('full_name')" required autofocus autocomplete="contact_name" />
                        <x-input-error :messages="$errors->get('full_name')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="company_name" :value="__('Company Name')" />
                        <x-text-input id="company_name" class="block mt-1 w-full" type="text" name="company_name" :value="old('company_name')" required autofocus autocomplete="contact_email" />
                        <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="company_address" :value="__('Company Address')" />
                        <x-text-input id="company_address" class="block mt-1 w-full" type="text" name="company_address" :value="old('company_address')" required autofocus autocomplete="contact_phone_number" />
                        <x-input-error :messages="$errors->get('company_address')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="gst_number" :value="__('Company GST Number')" />
                        <x-text-input id="gst_number" class="block mt-1 w-full" type="text" name="gst_number" :value="old('gst_number')" required autofocus autocomplete="company_name" />
                        <x-input-error :messages="$errors->get('gst_number')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="currency" :value="__('Currency')" />
                        <select id="currency" name="currency" class="block mt-1 w-full" required>
                            @foreach (\App\Enums\CurrencyEnum::cases() as $currency)
                                <option value="{{ $currency->value }}">{{ $currency->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>

                    <x-primary-button class="mt-4">
                        {{ __('Save') }}
                    </x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
