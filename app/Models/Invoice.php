<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['vendor_id', 'invoice_number', 'description'];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
    public function getTotalAmountAttribute()
    {
        return $this->items->sum(fn ($item) => $item->quantity * $item->price_per_unit);
    }
}
