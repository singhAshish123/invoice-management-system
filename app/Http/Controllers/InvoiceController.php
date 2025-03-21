<?php

namespace App\Http\Controllers;

use App\Jobs\SendInvoiceJob;
use App\Models\Invoice;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Models\InvoiceItem;
use App\Models\Product;
use App\Models\Vendor;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::with(['vendor', 'items.product'])->paginate(10);
        return view('invoice.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vendors = Vendor::all();
        $products = Product::all();

        return view('invoice.create', compact('vendors', 'products'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'invoice_number' => 'required|unique:invoices,invoice_number',
            'description' => 'nullable|string',
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {
            $invoice = Invoice::create([
                'vendor_id' => $request->vendor_id,
                'invoice_number' => $request->invoice_number,
                'description' => $request->description,
            ]);

            foreach ($request->products as $product) {
                $productDetails = Product::findOrFail($product['id']);

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'product_id' => $productDetails->id,
                    'quantity' => $product['quantity'],
                    'price_per_unit' => $productDetails->price_per_unit,
                ]);
            }
        });

        return redirect()->route('invoices.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        $vendors = Vendor::all();
        $products = Product::all();

        return view('invoice.edit', compact('invoice', 'vendors', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'invoice_number' => 'required|unique:invoices,invoice_number,' . $invoice->id,
            'description' => 'nullable|string',
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);
        $invoice->update([
            'vendor_id' => $validated['vendor_id'],
            'invoice_number' => $validated['invoice_number'],
            'description' => $validated['description'] ?? null,
        ]);
        $invoice->items()->delete();

        foreach ($validated['products'] as $product) {
            $productModel = Product::find($product['id']);

            if ($productModel) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'product_id' => $productModel->id,
                    'quantity' => $product['quantity'],
                    'price_per_unit' => $productModel->price_per_unit,
                ]);
            }
        }

        return redirect()->route('invoices.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->items()->delete();
        $invoice->delete();
        return redirect()->route('invoices.index');
    }

    public function download(Invoice $invoice)
    {
        $invoice->load(['vendor', 'items.product']);

        $pdf = Pdf::loadView('invoice.pdf', compact('invoice'));

        return $pdf->download("Invoice-{$invoice->invoice_number}.pdf");
    }

    public function sendInvoice(Invoice $invoice)
    {
        $email = $invoice->vendor->email;
        SendInvoiceJob::dispatch($invoice, $email);

        return redirect()->back()->with('success', 'Invoice is being sent successfully.');
    }


}
