<!DOCTYPE html>
<html>
<head>
    <title>Invoice #{{ $invoice->invoice_number }}</title>
</head>
<body>
<h1>Invoice #{{ $invoice->invoice_number }}</h1>
<p><strong>Vendor:</strong> {{ $invoice->vendor->company_name }}</p>
<p><strong>Description:</strong> {{ $invoice->description }}</p>

<h3>Products</h3>
@if ($invoice->items->count())
    <table border="1" cellspacing="0" cellpadding="5">
        <thead>
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Price Per Unit</th>
            <th>Subtotal</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($invoice->items as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->price_per_unit, 2) }}</td>
                <td>{{ number_format($item->quantity * $item->price_per_unit, 2) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <p><strong>Total: {{ number_format($invoice->total_amount, 2) }}</strong></p>
@else
    <p>No products added to this invoice.</p>
@endif
</body>
</html>
