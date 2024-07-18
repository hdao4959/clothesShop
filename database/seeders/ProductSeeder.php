<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductGallery;
use App\Models\ProductSize;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Nette\Utils\Random;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $name = fake()->text(20);
            Product::create([
                'category_id' => rand(1, 5),
                'name' => $name,
                'slug' => Str::slug($name) . '-' . Str::random(8),
                'sku' => Str::random(8) . $i,
                'img_thumbnail' => 'https://canifa.com/img/1517/2000/resize/6/t/6to23c001-sg553-2.webp',
                'price_regular' => 100000,
                'price_sale' => 90000,

            ]);
        }

        for ($i = 1; $i <= 5; $i++) {
            ProductGallery::create([
                'product_id' => $i,
                'image' => 'https://canifa.com/img/212/284/resize/6/t/6to23c001-sg553-3.webp'
            ]);
            ProductGallery::create([
                'product_id' => $i,
                'image' => 'https://canifa.com/img/212/284/resize/6/t/6to23c001-sg553-m-1.webp'
            ]);
        }

        for ($i = 1; $i <= 5; $i++) {
            DB::table('product_tag')->insert([
                [
                    'product_id' => $i,
                    'tag_id' => rand(1, 2)
                ],
                [
                    'product_id' => $i,
                    'tag_id' => rand(3, 5)
                ],

            ]);
        }

        // Vòng lặp của sản phẩm
        for ($productId = 1; $productId <= 5; $productId++) {
            $data = [];
            // Vòng lặp của biến thể size
            for ($sizeId = 1; $sizeId <= 6; $sizeId++) {
                $data[] = [
                    'product_id' => $productId,
                    'product_size_id' => $sizeId,
                    'quantity' => rand(10, 100)
                ];
            }
            DB::table("product_variants")->insert($data);
        }
    }
}
