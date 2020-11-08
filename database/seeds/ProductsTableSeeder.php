<?php

use Illuminate\Database\Seeder;
use App\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'title' => 'dir-605l-Wireless Cloud Router',
            'category_id' => '1',
            'brand_id' => '8',
            'description' => 'Very Nice Product Here',
            'image' => 'products/product-1.jpg,products/product-2.jpg,products/product-3.jpg',
            'price' => 12500,
            'top' => null
        ]);
        Product::create([
            'title' => 'dir-605l-Wireless Cloud Router',
            'category_id' => '2',
            'brand_id' => '7',
            'description' => 'Very Nice Product Here',
            'image' => 'products/product-1.jpg,products/product-2.jpg,products/product-3.jpg',
            'price' => 12500,
            'top' => 'on'
        ]);
        Product::create([
            'title' => 'dir-605l-Wireless Cloud Router',
            'category_id' => '3',
            'brand_id' => '6',
            'description' => 'Very Nice Product Here',
            'image' => 'products/product-1.jpg,products/product-2.jpg,products/product-3.jpg',
            'price' => 12500,
            'top' => null
        ]);
        Product::create([
            'title' => 'dir-605l-Wireless Cloud Router',
            'category_id' => '4',
            'brand_id' => '5',
            'description' => 'Very Nice Product Here',
            'image' => 'products/product-1.jpg,products/product-2.jpg,products/product-3.jpg',
            'price' => 12500,
            'top' => 'on'
        ]);
        Product::create([
            'title' => 'dir-605l-Wireless Cloud Router',
            'category_id' => '5',
            'brand_id' => '4',
            'description' => 'Very Nice Product Here',
            'image' => 'products/product-1.jpg,products/product-2.jpg,products/product-3.jpg',
            'price' => 12500,
            'top' => null
        ]);
        Product::create([
            'title' => 'dir-605l-Wireless Cloud Router',
            'category_id' => '6',
            'brand_id' => '3',
            'description' => 'Very Nice Product Here',
            'image' => 'products/product-1.jpg,products/product-2.jpg,products/product-3.jpg',
            'price' => 12500,
            'top' => 'on'
        ]);
        Product::create([
            'title' => 'dir-605l-Wireless Cloud Router',
            'category_id' => '7',
            'brand_id' => '2',
            'description' => 'Very Nice Product Here',
            'image' => 'products/product-1.jpg,products/product-2.jpg,products/product-3.jpg',
            'price' => 12500,
            'top' => null
        ]);
        Product::create([
            'title' => 'dir-605l-Wireless Cloud Router',
            'category_id' => '8',
            'brand_id' => '1',
            'description' => 'Very Nice Product Here',
            'image' => 'products/product-1.jpg,products/product-2.jpg,products/product-3.jpg',
            'price' => 12500,
            'top' => 'on'
        ]);
        Product::create([
            'title' => 'dir-605l-Wireless Cloud Router',
            'category_id' => '1',
            'brand_id' => '1',
            'description' => 'Very Nice Product Here',
            'image' => 'products/product-1.jpg,products/product-2.jpg,products/product-3.jpg',
            'price' => 12500,
            'top' => null
        ]);
        Product::create([
            'title' => 'dir-605l-Wireless Cloud Router',
            'category_id' => '2',
            'brand_id' => '8',
            'description' => 'Very Nice Product Here',
            'image' => 'products/product-1.jpg,products/product-2.jpg,products/product-3.jpg',
            'price' => 12500,
            'top' => 'on'
        ]);
        Product::create([
            'title' => 'dir-605l-Wireless Cloud Router',
            'category_id' => '3',
            'brand_id' => '7',
            'description' => 'Very Nice Product Here',
            'image' => 'products/product-1.jpg,products/product-2.jpg,products/product-3.jpg',
            'price' => 12500,
            'top' => null
        ]);
        Product::create([
            'title' => 'dir-605l-Wireless Cloud Router',
            'category_id' => '4',
            'brand_id' => '6',
            'description' => 'Very Nice Product Here',
            'image' => 'products/product-1.jpg,products/product-2.jpg,products/product-3.jpg',
            'price' => 12500,
            'top' => 'on'
        ]);
        Product::create([
            'title' => 'dir-605l-Wireless Cloud Router',
            'category_id' => '5',
            'brand_id' => '5',
            'description' => 'Very Nice Product Here',
            'image' => 'products/product-1.jpg,products/product-2.jpg,products/product-3.jpg',
            'price' => 12500,
            'top' => null
        ]);
        Product::create([
            'title' => 'dir-605l-Wireless Cloud Router',
            'category_id' => '6',
            'brand_id' => '4',
            'description' => 'Very Nice Product Here',
            'image' => 'products/product-1.jpg,products/product-2.jpg,products/product-3.jpg',
            'price' => 12500,
            'top' => 'on'
        ]);
        Product::create([
            'title' => 'dir-605l-Wireless Cloud Router',
            'category_id' => '7',
            'brand_id' => '3',
            'description' => 'Very Nice Product Here',
            'image' => 'products/product-1.jpg,products/product-2.jpg,products/product-3.jpg',
            'price' => 12500,
            'top' => null
        ]);

    }
}
