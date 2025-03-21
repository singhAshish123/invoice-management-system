<?php

namespace App\Models;

use App\Enums\CurrencyEnum;
use App\ProjectStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    /** @use HasFactory<\Database\Factories\VendorFactory> */
    use HasFactory;

    protected $fillable = ['full_name', 'email', 'company_name', 'company_address', 'gst_number', 'currency'];

    protected function casts()
    {
        return [
            'currency' => CurrencyEnum::class,
        ];
    }
}
