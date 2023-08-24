<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        Product::create([
            'name' => 'Product 1',
            'sku' => 'PRD001',
            'stock' => 10,
            'purchase_price' => 10000,
            'selling_price' => 15000,
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.',
        ]);        
        Product::create([
            'name' => 'Product 2',
            'sku' => 'PRD002',
            'stock' => 10,
            'purchase_price' => 10000,
            'selling_price' => 15000,
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.',
        ]);        
        Product::create([
            'name' => 'Product 3',
            'sku' => 'PRD003',
            'stock' => 10,
            'purchase_price' => 10000,
            'selling_price' => 15000,
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.',
        ]);
        

        Order::create([
            'invoice_no' => 1,
            'customer_name' => 'Customer 1',
            'customer_email' => 'a@xyz.com',
            'payment_method' => 'Cash',
        ]);

        Order::create([
            'invoice_no' => 2,
            'customer_name' => 'Customer 1',
            'customer_email' => 'a@xyz.com',
            'payment_method' => 'Cash',
        ]);

        Order::create([
            'invoice_no' => 3,
            'customer_name' => 'Customer 1',
            'customer_email' => 'a@xyz.com',
            'payment_method' => 'Cash',
        ]);

        Order::create([
            'invoice_no' => 4,
            'customer_name' => 'Customer 1',
            'customer_email' => 'a@xyz.com',
            'payment_method' => 'Cash',
        ]);

        
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
