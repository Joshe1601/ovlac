<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductPart;
use App\Models\ProductPartVariation;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call('UsersTableSeeder');
        $prod1 = Product::create([
            'title' => 'Product 1', 
            'description' => 'Product 1', 
            'price' => '100', 
        ]);

        $part1 = ProductPart::create([
            'title' => 'Part 1', 
            'description' => 'Part 1', 
            'price' => 0, 
            'color' => 'ee00ff',
            'product_id' => 1,
            'fixed' => 1,
        ]);

    }
}
