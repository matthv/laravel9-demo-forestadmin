<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Car;
use App\Models\Category;
use App\Models\Check;
use App\Models\User;
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

        $faker = Factory::create();

        $small = Category::create(['label' => 'small']);
        $medium = Category::create(['label' => 'medium']);
        $large = Category::create(['label' => 'large']);
        $estate = Category::create(['label' => 'estate']);
        $premium = Category::create(['label' => 'premium']);
        $suv = Category::create(['label' => 'suv']);

        Car::create(['reference' => $faker->regexify('[A-Z]{2}[0-4]{3}'), 'model' => 'FIAT 500', 'brand' => 'FIAT', 'year' => 2020, 'nb_seats' => 4, 'category_id' => $small->id]);
        Car::create(['reference' => $faker->regexify('[A-Z]{2}[0-4]{3}'), 'model' => 'FORD FIESTA', 'brand' => 'FORD', 'year' => 2020, 'nb_seats' => 5, 'category_id' => $small->id]);
        Car::create(['reference' => $faker->regexify('[A-Z]{2}[0-4]{3}'), 'model' => 'PEUGEOT 208', 'brand' => 'PEUGEOT', 'year' => 2021, 'nb_seats' => 5, 'category_id' => $small->id]);

        Car::create(['reference' => $faker->regexify('[A-Z]{2}[0-4]{3}'), 'model' => 'FORD FOCUS', 'brand' => 'FORD', 'year' => 2021, 'nb_seats' => 5, 'category_id' => $medium->id]);
        Car::create(['reference' => $faker->regexify('[A-Z]{2}[0-4]{3}'), 'model' => 'SEAT LEON', 'brand' => 'SEAT', 'year' => 2021, 'nb_seats' => 5, 'category_id' => $medium->id]);

        Car::create(['reference' => $faker->regexify('[A-Z]{2}[0-4]{3}'), 'model' => 'PEUGEOT 3008', 'brand' => 'PEUGEOT', 'year' => 2020, 'nb_seats' => 5, 'category_id' => $large->id]);
        Car::create(['reference' => $faker->regexify('[A-Z]{2}[0-4]{3}'), 'model' => 'HONDA CR-V', 'brand' => 'HONDA', 'year' => 2021, 'nb_seats' => 5, 'category_id' => $large->id]);
        Car::create(['reference' => $faker->regexify('[A-Z]{2}[0-4]{3}'), 'model' => 'SKODA OCTAVIA', 'brand' => 'SKODA', 'year' => 2022, 'nb_seats' => 5, 'category_id' => $large->id]);

        Car::create(['reference' => $faker->regexify('[A-Z]{2}[0-4]{3}'), 'model' => 'SEAT LEON ESTATE', 'brand' => 'SEAT', 'year' => 2020, 'nb_seats' => 5, 'category_id' => $estate->id]);
        Car::create(['reference' => $faker->regexify('[A-Z]{2}[0-4]{3}'), 'model' => 'VOLKSWAGEN PASSAT ESTATE', 'brand' => 'VOLKSWAGEN', 'year' => 2021, 'nb_seats' => 5, 'category_id' => $estate->id]);

        Car::create(['reference' => $faker->regexify('[A-Z]{2}[0-4]{3}'), 'model' => 'BMW 5 SERIES', 'brand' => 'BMW', 'year' => 2021, 'nb_seats' => 5, 'category_id' => $premium->id, 'is_manual' => false]);
        Car::create(['reference' => $faker->regexify('[A-Z]{2}[0-4]{3}'), 'model' => 'MERCEDES-BENZ C-CLASS CR-V', 'brand' => 'MERCEDES-BENZ', 'year' => 2021, 'nb_seats' => 5, 'category_id' => $premium->id, 'is_manual' => false]);

        Car::create(['reference' => $faker->regexify('[A-Z]{2}[0-4]{3}'), 'model' => 'KIA STONIC', 'brand' => 'KIA', 'year' => 2022, 'nb_seats' => 5, 'category_id' => $suv->id]);
        Car::create(['reference' => $faker->regexify('[A-Z]{2}[0-4]{3}'), 'model' => 'OPEL MOKKA', 'brand' => 'OPEL', 'year' => 2021, 'nb_seats' => 5, 'category_id' => $suv->id]);
        Car::create(['reference' => $faker->regexify('[A-Z]{2}[0-4]{3}'), 'model' => 'NISSAN QASHQAI', 'brand' => 'NISSAN', 'year' => 2021, 'nb_seats' => 5, 'category_id' => $suv->id]);

        $carIds = Car::pluck('id');
        $userIds = User::pluck('id');

        for ($i = 0; $i < 50; $i++) {
            Check::create(['date' => $faker->dateTimeBetween('-1 year', '+5 week'), 'garage_name' => $faker->company()]);
            $startDate = $faker->dateTimeBetween('-3 week', '+2 week');
            Booking::create(['start_date' => $startDate, 'end_date' => Carbon::parse($startDate)->addDays(5), 'car_id' => $faker->randomElement($carIds), 'user_id' => $faker->randomElement($userIds)]);
        }

        $checkIds = Check::pluck('id');
        for ($i = 0; $i < 150; $i++) {
            DB::table('car_check')->insert(['car_id' => $faker->randomElement($carIds), 'check_id' => $faker->randomElement($checkIds), 'created_at' => now(), 'updated_at' => now()]);
        }
    }
}
