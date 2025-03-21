<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Dashboard Overview</h3>

                <form method="GET" action="{{ route('dashboard') }}" class="mb-4">
                    <label for="filter" class="block font-semibold">Filter by Time:</label>
                    <select name="filter" id="filter" class="border rounded p-2" onchange="this.form.submit()">
                        <option value="today" {{ $timeFilter == 'today' ? 'selected' : '' }}>Today</option>
                        <option value="this_week" {{ $timeFilter == 'this_week' ? 'selected' : '' }}>This Week</option>
                        <option value="this_month" {{ $timeFilter == 'this_month' ? 'selected' : '' }}>This Month</option>
                        <option value="this_year" {{ $timeFilter == 'this_year' ? 'selected' : '' }}>This Year</option>
                        <option value="custom" {{ $timeFilter == 'custom' ? 'selected' : '' }}>Custom</option>
                    </select>

                    <div id="customDateFields" class="mt-2" style="display: {{ $timeFilter == 'custom' ? 'block' : 'none' }}">
                        <input type="date" name="start_date" class="border rounded p-2" value="{{ request('start_date') }}" required>
                        <input type="date" name="end_date" class="border rounded p-2" value="{{ request('end_date') }}" required>
                        <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded">Apply</button>
                    </div>
                </form>

                @if(Auth::user()->hasRole('admin'))
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-blue-500 text-white p-4 rounded-lg shadow">
                            <h4 class="text-xl font-bold">{{ $totalUsers }}</h4>
                            <p>Total Users</p>
                        </div>
                        <div class="bg-green-500 text-white p-4 rounded-lg shadow">
                            <h4 class="text-xl font-bold">{{ $totalInvoices }}</h4>
                            <p>Total Invoices</p>
                        </div>
                    </div>
                @else
                    <div class="grid grid-cols-3 gap-4">
                        <div class="bg-blue-500 text-white p-4 rounded-lg shadow">
                            <h4 class="text-xl font-bold">{{ $totalVendors }}</h4>
                            <p>Total Vendors</p>
                        </div>
                        <div class="bg-green-500 text-white p-4 rounded-lg shadow">
                            <h4 class="text-xl font-bold">{{ $totalProducts }}</h4>
                            <p>Total Products</p>
                        </div>
                        <div class="bg-yellow-500 text-white p-4 rounded-lg shadow">
                            <h4 class="text-xl font-bold">{{ $totalInvoices }}</h4>
                            <p>Total Invoices</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let filterDropdown = document.getElementById('filter');
            let customDateFields = document.getElementById('customDateFields');

            filterDropdown.addEventListener('change', function() {
                customDateFields.style.display = this.value === 'custom' ? 'block' : 'none';
            });
        });
    </script>
</x-app-layout>
