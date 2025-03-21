<!DOCTYPE html>
<html>
<head>
    <title>Your Invoice</title>
</head>
<body>
<h2>Dear {{ $invoice->vendor->company_name }},</h2>

<p>Please find the details of your invoice below:</p>

<h3>Invoice Details:</h3>
<p><strong>Invoice Number:</strong> {{ $invoice->invoice_number }}</p>
<p><strong>Date:</strong> {{ $invoice->created_at->format('d M, Y') }}</p>
<p><strong>Description:</strong> {{ $invoice->description ?? 'N/A' }}</p>

<h3>Vendor Details:</h3>
<p><strong>Vendor Name:</strong> {{ $invoice->vendor->name }}</p>
<p><strong>Company:</strong> {{ $invoice->vendor->company_name }}</p>
<p><strong>Address:</strong> {{ $invoice->vendor->address }}</p>
<p><strong>Email:</strong> {{ $invoice->vendor->email }}</p>

<h3>Products:</h3>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>Product Name</th>
        <th>Quantity</th>
        <th>Unit Price (₹)</th>
        <th>Total (₹)</th>
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

<h3>Total Amount: ₹{{ number_format($invoice->items->sum(fn($item) => $item->quantity * $item->price_per_unit), 2) }}</h3>

<p>Thank you for your business!</p>
</body>
</html>
