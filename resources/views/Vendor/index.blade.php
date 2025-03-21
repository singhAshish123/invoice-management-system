<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Vendors') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Vendor List</h3>
                        <a href="{{ route('vendors.create') }}"
                           class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                            + Add Vendor
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse border border-gray-300">
                            <thead class="bg-gray-100">
                            <tr>
                                <th class="border border-gray-300 px-4 py-2 text-left">Full Name</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Company Name</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Company Address</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">GST Number</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Currency</th>
                                <th class="border border-gray-300 px-4 py-2 text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                            @foreach ($vendors as $vendor)
                                <tr class="hover:bg-gray-50">
                                    <td class="border border-gray-300 px-4 py-2">{{ $vendor->full_name }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $vendor->company_name }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $vendor->company_address }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $vendor->gst_number }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $vendor->currency }}</td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">
                                        <a href="{{ route('vendors.edit', $vendor) }}"
                                           class="text-indigo-600 hover:text-indigo-900 font-medium">
                                            Edit
                                        </a>

                                        <form action="{{ route('vendors.destroy', $vendor) }}"
                                              method="POST"
                                              onsubmit="return confirm('Are you sure?')"
                                              class="inline-block ml-4">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-red-600 hover:text-red-900 font-medium">
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
                        {{ $vendors->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
