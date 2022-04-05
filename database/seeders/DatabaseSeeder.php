<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Car;
use App\Models\Category;
use App\Models\Check;
use App\Models\Chef;
use App\Models\ChefAvailability;
use App\Models\Customer;
use App\Models\DeliveryMen;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Database\Factories\OrderFactory;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(50)->create();
        Product::factory(50)->create();
        Customer::factory(50)->create();
        Order::factory(100)->create();

        $products = Product::all();
        $orders = Order::all();
        Menu::factory(20)
            ->create()
            ->each(function ($menu) use ($products, $orders) {
                $menu->products()->attach($products->random()->id);
                $menu->products()->attach($products->random()->id);
                $menu->products()->attach($products->random()->id);

                $menu->orders()->attach($orders->random()->id);
                $menu->orders()->attach($orders->random()->id);
                $menu->orders()->attach($orders->random()->id);
            });

        $orders->each(function ($order) use ($products) {
            $order->products()->attach($products->random()->id);
            $order->products()->attach($products->random()->id);
            $order->products()->attach($products->random()->id);
        });

        DeliveryMen::factory(30)->create();
        Chef::factory(40)->create();
        ChefAvailability::factory(40);
    }
}
