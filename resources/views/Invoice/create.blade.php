<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Invoice') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('invoices.store') }}">
                    @csrf

                    <!-- Select Vendor -->
                    <div class="mb-4">
                        <x-input-label for="vendor_id" :value="__('Select Vendor')" />
                        <select id="vendor_id" name="vendor_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                            @foreach ($vendors as $vendor)
                                <option value="{{ $vendor->id }}">{{ $vendor->company_name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('vendor_id')" class="mt-2" />
                    </div>

                    <!-- Invoice Number -->
                    <div class="mb-4">
                        <x-input-label for="invoice_number" :value="__('Invoice Number')" />
                        <x-text-input id="invoice_number" class="block mt-1 w-full" type="text" name="invoice_number" required />
                        <x-input-error :messages="$errors->get('invoice_number')" class="mt-2" />
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea id="description" name="description" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"></textarea>
                    </div>

                    <!-- Product Selection -->
                    <div id="product-list">
                        <x-input-label :value="__('Select Products & Quantity')" />
                        <div class="mb-4 flex space-x-4 product-row" data-index="0">
                            <select name="products[0][id]" class="block w-full border-gray-300 rounded-md shadow-sm">
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }} (₹{{ $product->price_per_unit }})</option>
                                @endforeach
                            </select>
                            <x-text-input name="products[0][quantity]" class="block w-20 border-gray-300 rounded-md shadow-sm" type="number" min="1" value="1" required />
                        </div>
                    </div>

                    <!-- Add More Products Button -->
                    <button type="button" id="add-product" class="bg-green-500 text-white px-3 py-1 rounded">
                        + Add Product
                    </button>

                    <!-- Submit -->
                    <x-primary-button class="mt-4">
                        {{ __('Create Invoice') }}
                    </x-primary-button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('add-product').addEventListener('click', function() {
            let index = document.querySelectorAll('.product-row').length;
            let productDiv = document.createElement('div');
            productDiv.classList.add('mb-4', 'flex', 'space-x-4', 'product-row');
            productDiv.setAttribute('data-index', index);
            productDiv.innerHTML = `
                <select name="products[${index}][id]" class="block w-full border-gray-300 rounded-md shadow-sm">
                    @foreach ($products as $product)
            <option value="{{ $product->id }}">{{ $product->name }} (₹{{ $product->price_per_unit }})</option>
                    @endforeach
            </select>
            <x-text-input name="products[${index}][quantity]" class="block w-20 border-gray-300 rounded-md shadow-sm" type="number" min="1" value="1" required />
                <button type="button" class="remove-product bg-red-500 text-white px-2 py-1 rounded">X</button>
            `;
            document.getElementById('product-list').appendChild(productDiv);
            updateRemoveButtons();
        });

        document.getElementById('product-list').addEventListener('click', function(event) {
            if (event.target.classList.contains('remove-product')) {
                event.target.closest('.product-row').remove();
                updateRemoveButtons();
            }
        });

        function updateRemoveButtons() {
            let productRows = document.querySelectorAll('.product-row');
            productRows.forEach((row, index) => {
                let removeBtn = row.querySelector('.remove-product');
                if (removeBtn) {
                    removeBtn.style.display = productRows.length > 1 ? 'inline-block' : 'none';
                }
            });
        }
    </script>
</x-app-layout>
