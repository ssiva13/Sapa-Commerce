<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'title' => 'Routers'
        ]);
        Category::create([
            'title' => 'Switches'
        ]);
        Category::create([
            'title' => 'Tools'
        ]);
        Category::create([
            'title' => 'Wireless Networks'
        ]);
        Category::create([
            'title' => 'Cabled Networks'
        ]);
        Category::create([
            'title' => 'Tools'
        ]);
        Category::create([
            'title' => 'Panasonic'
        ]);
        Category::create([
            'title' => 'Accessories'
        ]);
    }
}
