<?php

use Illuminate\Database\Seeder;
use App\Brand;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Brand::create([
            'title' => 'Dlink'
        ]);
        Brand::create([
            'title' => 'Mikrotik'
        ]);
        Brand::create([
            'title' => 'Archer'
        ]);
        Brand::create([
            'title' => 'Unifi'
        ]);
        Brand::create([
            'title' => 'Tp-Link'
        ]);
        Brand::create([
            'title' => 'Cisco'
        ]);
        Brand::create([
            'title' => 'Ubiquity'
        ]);
        Brand::create([
            'title' => 'Panasonic'
        ]);
    }
}
