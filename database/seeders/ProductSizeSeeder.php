<?php

namespace Database\Seeders;

use App\Models\ProductSize;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $size = ['M', "L", "S", "XS", "XL", 'XXL'];
        foreach($size as $item){
            ProductSize::create([
                'name' => $item
            ]);
        }
    }
}
