<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
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
        $this->call([
            UsersTableSeeder::class,
        ]);

        User::factory()->count(100)->has(
            Order::factory()->count(3)->hasAttached(
                Product::factory()->count(3), function ($order) {
                $qty = random_int(1, 100); $price = random_int(1, 100000); $total = $qty * $price;
                $order->total += $qty * $price;
                $order->save();
                return [ 'qty' => $qty, 'price' => $price, 'total' => $total ];
            })
        )->create();

    }
}
