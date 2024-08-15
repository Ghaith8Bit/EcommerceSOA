<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Services\Product\Models\Product::create([
            'name' => 'Product 1',
            'description' => 'Description for product 1',
            'price' => 19.99,
            'quantity' => 100
        ]);

        \App\Services\Product\Models\Product::create([
            'name' => 'Product 2',
            'description' => 'Description for product 2',
            'price' => 29.99,
            'quantity' => 200
        ]);

        \App\Services\Auth\Models\User::create([
            'name' => 'Test User',
            'email' => 'admin@a.com',
            'password' => 'password'
        ]);
    }
}
