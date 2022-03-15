<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'uuid' => Str::uuid(),
            "name" => "Burger classique",
            "image" => "products/DtNtqr7kgTvgv81SxcnBpKBSeTbCcTklCBEmex8E.png",
            "description" => "Le burger classique est composé de la viande, de la tomate, de l'oignon et de la salade.",
            "price" => 1000
        ]);
    }
}
