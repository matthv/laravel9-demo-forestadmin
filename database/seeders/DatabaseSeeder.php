<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Address;
use App\Models\Booking;
use App\Models\Car;
use App\Models\Category;
use App\Models\Check;
use App\Models\Chef;
use App\Models\ChefAvailability;
use App\Models\Company;
use App\Models\DeliveryMen;
use App\Models\Department;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Product;
use App\Models\Transaction;
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
        Product::factory(50)->create();
        Address::factory(50)->create();
        Company::factory(50)->create();
        Transaction::factory(200)->create();
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

        $companies = Company::all();
        Book::factory(50)
            ->create()
            ->each(function ($book) use ($companies) {
                $book->companies()->attach($companies->random()->id);
                $book->companies()->attach($companies->random()->id);
            });

        Department::factory(100)->create();
        User::factory(50)->create();
    }
}
