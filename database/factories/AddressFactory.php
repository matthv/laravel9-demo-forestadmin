<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class CustomerFactory
 *
 * @package  Laravel9-demo-forestadmin
 * @license  GNU https://www.gnu.org/licences/licences.html
 * @link     https://github.com/ForestAdmin/laravel-forestadmin
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'address_line1' => $this->faker->address(),
            'address_city'  => $this->faker->city(),
            'country'       => $this->faker->country(),
            'customer_id'   => Customer::factory()->create()->id,
        ];
    }
}
