<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\User::create([
            'name' => 'Techblaze Admin',
            'slug' => str_slug('Techblaze Admin'),
            'email' => 'info@techblaze.co.ke',
            'phone' => '+254 723 077XXX',
            'type' => 'super',
            'is_admin' => true,
            'password' => bcrypt('@techblaze')
        ]);
       
        App\User::create([
            'name' => 'Developer@Test',
            'slug' => str_slug('Developer@Test'),
            'email' => 'info@24seven.co.ke',
            'phone' => '+254 7XX XXXXXX',
            'type' => 'super',
            'is_admin' => true,
            'password' => bcrypt('@24seven'),
            'view' => false
        ]);
       
        App\User::create([
            'name' => 'Techblaze User',
            'slug' => str_slug('Techblaze User'),
            'email' => 'user@techblaze.co.ke',
            'phone' => '+254 723 077XXX',
            'password' => bcrypt('@user')
        ]);
       
    }
}
