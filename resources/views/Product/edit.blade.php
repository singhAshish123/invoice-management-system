<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('products.update',$product) }}" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                    <!-- Name -->
                    <div class="mt-4">
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('full_name',$product->name)" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="image" :value="__('Image')" />
                        <x-text-input id="image" class="block mt-1 w-full" type="file" name="image" :value="old('image')" required autofocus autocomplete="image" />
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        @if(isset($product) && $product->image)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" width="100" height="100" class="w-32 h-32 rounded">
                            </div>
                        @endif
                    </div>

                    <div class="mt-4">
                        <x-input-label for="price_per_unit" :value="__('Price Per Unit')" />
                        <x-text-input id="price_per_unit" class="block mt-1 w-full" type="text" name="price_per_unit" :value="old('price_per_unit', $product->price_per_unit)" required autofocus autocomplete="contact_phone_number" />
                        <x-input-error :messages="$errors->get('price_per_unit')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="unit" :value="__('Product Unit')" />
                        <select id="unit" name="unit" class="block mt-1 w-full" required>
                            @foreach (\App\Enums\ProductEnum::cases() as $unit)
                                <option value="{{ $unit->value }}" {{ old('status', $product->unit->value) == $unit->value ? 'selected' : '' }}>
                                    {{ $unit->name }}
                                </option>
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
