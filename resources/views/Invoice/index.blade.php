<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Invoices') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        @if (session('success'))
                            <div class="mb-4 px-4 py-2 bg-green-100 border border-green-400 text-green-700 rounded">
                                {{ session('success') }}
                            </div>
                        @endif
                        <h3 class="text-lg font-semibold">Invoice List</h3>
                        <a href="{{ route('invoices.create') }}"
                           class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                            + Create Invoice
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse border border-gray-300">
                            <thead class="bg-gray-100">
                            <tr>
                                <th class="border border-gray-300 px-4 py-2 text-left">Invoice Number</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Vendor</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Description</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Total Amount</th>
                                <th class="border border-gray-300 px-4 py-2 text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                            @foreach ($invoices as $invoice)
                                <tr class="hover:bg-gray-50">
                                    <td class="border border-gray-300 px-4 py-2">{{ $invoice->invoice_number }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $invoice->vendor->company_name }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $invoice->description ?? 'N/A' }}</td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        ₹{{ $invoice->items->sum(fn($item) => $item->quantity * $item->price_per_unit) }}
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">
                                        <a href="{{ route('invoices.edit', $invoice) }}" class="text-indigo-600 hover:text-indigo-900 font-medium ml-3">
                                            Edit
                                        </a>

                                        <a href="{{ route('invoices.download', $invoice) }}" class="text-green-600 hover:text-green-900 font-medium ml-3">
                                            Download
                                        </a>

                                        <a href="{{ route('invoices.mail', $invoice) }}" class="text-blue-600 hover:text-blue-900 font-medium ml-3">
                                            Send via Email
                                        </a>

                                        <form action="{{ route('invoices.destroy', $invoice) }}" method="POST"
                                              onsubmit="return confirm('Are you sure?')" class="inline-block ml-3">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 font-medium">
                                                Delete
                                            </button>
                                        </form>
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $invoices->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
