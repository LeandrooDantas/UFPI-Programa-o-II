<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MassiveSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        /*
        |--------------------------------------------------------------------------
        | Categories
        |--------------------------------------------------------------------------
        */
        $categories = [];

        for ($i = 1; $i <= 100; $i++) {
            $categories[] = [
                'name' => fake()->unique()->word(),
                'description' => fake()->sentence(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('categories')->insert($categories);

        /*
        |--------------------------------------------------------------------------
        | Suppliers
        |--------------------------------------------------------------------------
        */
        $suppliers = [];

        for ($i = 1; $i <= 500; $i++) {
            $suppliers[] = [
                'name' => fake()->company(),
                'email' => fake()->companyEmail(),
                'phone' => fake()->phoneNumber(),
                'city' => fake()->city(),
                'state' => fake()->stateAbbr(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('suppliers')->insert($suppliers);

        /*
        |--------------------------------------------------------------------------
        | Users
        |--------------------------------------------------------------------------
        */
        $users = [];

        for ($i = 1; $i <= 5000; $i++) {

            $users[] = [
                'name' => fake()->name(),
                'email' => "user{$i}@teste.com",
                'password' => Hash::make('123456'),
                'role' => fake()->randomElement([
                    'admin',
                    'employee',
                    'customer'
                ]),
                'active' => fake()->boolean(90),
                'last_login_at' => fake()->dateTimeBetween('-1 year'),
                'remember_token' => fake()->regexify('[A-Za-z0-9]{10}'),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (count($users) >= 1000) {
                DB::table('users')->insert($users);
                $users = [];
            }
        }

        if (!empty($users)) {
            DB::table('users')->insert($users);
        }

        /*
        |--------------------------------------------------------------------------
        | Products
        |--------------------------------------------------------------------------
        */
        $products = [];

        for ($i = 1; $i <= 10000; $i++) {

            $products[] = [
                'name' => fake()->words(3, true),
                'description' => fake()->paragraph(),
                'price' => fake()->randomFloat(2, 10, 5000),
                'stock_quantity' => rand(0, 1000),
                'category' => fake()->randomElement([
                    'Informática',
                    'Eletrônicos',
                    'Esporte',
                    'Livros',
                    'Casa',
                ]),
                'sku' => 'SKU-' . $i,
                'active' => fake()->boolean(95),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (count($products) >= 1000) {
                DB::table('products')->insert($products);
                $products = [];
            }
        }

        if (!empty($products)) {
            DB::table('products')->insert($products);
        }

        /*
        |--------------------------------------------------------------------------
        | Addresses
        |--------------------------------------------------------------------------
        */
        $addresses = [];

        for ($i = 1; $i <= 5000; $i++) {

            $addresses[] = [
                'user_id' => rand(1, 5000),
                'street' => fake()->streetName(),
                'number' => rand(1, 9999),
                'district' => fake()->citySuffix(),
                'city' => fake()->city(),
                'state' => fake()->stateAbbr(),
                'zip_code' => fake()->postcode(),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (count($addresses) >= 1000) {
                DB::table('addresses')->insert($addresses);
                $addresses = [];
            }
        }

        if (!empty($addresses)) {
            DB::table('addresses')->insert($addresses);
        }

        /*
        |--------------------------------------------------------------------------
        | Orders
        |--------------------------------------------------------------------------
        */
        $statuses = [
            'pending',
            'paid',
            'shipped',
            'delivered',
            'cancelled'
        ];

        $orders = [];

        for ($i = 1; $i <= 20000; $i++) {

            $orders[] = [
                'user_id' => rand(1, 5000),
                'total_amount' => rand(50, 5000),
                'status' => fake()->randomElement($statuses),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (count($orders) >= 1000) {
                DB::table('orders')->insert($orders);
                $orders = [];
            }
        }

        if (!empty($orders)) {
            DB::table('orders')->insert($orders);
        }

        /*
        |--------------------------------------------------------------------------
        | Payments
        |--------------------------------------------------------------------------
        */
        $payments = [];

        for ($i = 1; $i <= 20000; $i++) {

            $payments[] = [
                'order_id' => $i,
                'amount' => rand(50, 5000),
                'payment_method' => fake()->randomElement([
                    'pix',
                    'credit_card',
                    'debit_card',
                    'cash'
                ]),
                'status' => fake()->randomElement([
                    'pending',
                    'approved',
                    'refused'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('payments')->insert($payments);

        /*
        |--------------------------------------------------------------------------
        | Reviews
        |--------------------------------------------------------------------------
        */
        $reviews = [];

        for ($i = 1; $i <= 30000; $i++) {

            $reviews[] = [
                'user_id' => rand(1, 5000),
                'product_id' => rand(1, 10000),
                'rating' => rand(1, 5),
                'comment' => fake()->sentence(),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (count($reviews) >= 1000) {
                DB::table('reviews')->insert($reviews);
                $reviews = [];
            }
        }

        if (!empty($reviews)) {
            DB::table('reviews')->insert($reviews);
        }

        /*
        |--------------------------------------------------------------------------
        | Favorites
        |--------------------------------------------------------------------------
        */
        $favorites = [];

        for ($i = 1; $i <= 20000; $i++) {

            $favorites[] = [
                'user_id' => rand(1, 5000),
                'product_id' => rand(1, 10000),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (count($favorites) >= 1000) {
                DB::table('favorites')->insert($favorites);
                $favorites = [];
            }
        }

        if (!empty($favorites)) {
            DB::table('favorites')->insert($favorites);
        }

        /*
        |--------------------------------------------------------------------------
        | Inventory Movements
        |--------------------------------------------------------------------------
        */
        $movements = [];

        for ($i = 1; $i <= 30000; $i++) {

            $movements[] = [
                'product_id' => rand(1, 10000),
                'type' => fake()->randomElement(['entry', 'exit']),
                'quantity' => rand(1, 100),
                'reason' => fake()->sentence(3),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (count($movements) >= 1000) {
                DB::table('inventory_movements')->insert($movements);
                $movements = [];
            }
        }

        if (!empty($movements)) {
            DB::table('inventory_movements')->insert($movements);
        }

        /*
        |--------------------------------------------------------------------------
        | Order Items
        |--------------------------------------------------------------------------
        */
        $items = [];

        for ($i = 1; $i <= 100000; $i++) {

            $items[] = [
                'order_id' => rand(1, 20000),
                'product_id' => rand(1, 10000),
                'quantity' => rand(1, 10),
                'unit_price' => rand(10, 5000),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (count($items) >= 1000) {
                DB::table('order_items')->insert($items);
                $items = [];
            }
        }

        if (!empty($items)) {
            DB::table('order_items')->insert($items);
        }

        /*
        |--------------------------------------------------------------------------
        | Coupons
        |--------------------------------------------------------------------------
        */
        $coupons = [];

        for ($i = 1; $i <= 500; $i++) {

            $coupons[] = [
                'code' => strtoupper(fake()->bothify('CUPOM-####')),
                'discount_percentage' => rand(5, 50),
                'expires_at' => now()->addDays(rand(30, 365)),
                'active' => fake()->boolean(80),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('coupons')->insert($coupons);

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
