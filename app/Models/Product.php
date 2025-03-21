<?php

namespace App\Models;

use App\Enums\CurrencyEnum;
use App\Enums\ProductEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = ['name', 'image', 'unit', 'price_per_unit'];

    protected function casts()
    {
        return [
            'unit' => ProductEnum::class,
        ];
    }
}
