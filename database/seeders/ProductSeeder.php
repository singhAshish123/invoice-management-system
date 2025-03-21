<?php

namespace Database\Seeders;

use App\Enums\ProductEnum;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('products')->insert([
            [
                'name' => 'Sugar',
                'image' => 'products/sugar.webp',
                'unit' => ProductEnum::KG->value,
                'price_per_unit' => 50.00,
            ],
            [
                'name' => 'Milk',
                'image' => 'products/milk.webp',
                'unit' => ProductEnum::LITRE->value,
                'price_per_unit' => 40.00,
            ],
            [
                'name' => 'Wood Plank',
                'image' => 'products/wood.webp',
                'unit' => ProductEnum::FOOT->value,
                'price_per_unit' => 100.00,
            ],
            [
                'name' => 'Pen',
                'image' => 'products/pen.webp',
                'unit' => ProductEnum::PIECE->value,
                'price_per_unit' => 10.00,
            ],
        ]);
    }
}
