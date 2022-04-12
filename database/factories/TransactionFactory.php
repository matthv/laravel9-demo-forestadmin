<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class TransactionFactory
 *
 * @package  Laravel9-demo-forestadmin
 * @license  GNU https://www.gnu.org/licences/licences.html
 * @link     https://github.com/ForestAdmin/laravel-forestadmin
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $beneficiary_company = Company::all()->random();
        $emitter_company = Company::where('id', '!=', $beneficiary_company->id)->get()->random();

        return [
            'beneficiary_iban'       => $this->faker->iban(),
            'emitter_iban'           => $this->faker->iban(),
            'vat_amount'             => 20,
            'amount'                 => $this->faker->numberBetween(100, 1000),
            'fee_amount'             => $this->faker->numberBetween(10, 100),
            'note'                   => '',
            'emitter_bic'            => $this->faker->swiftBicNumber(),
            'beneficiary_bic'        => $this->faker->swiftBicNumber(),
            'reference'              => $this->faker->text(16),
            'status'                 => $this->faker->randomElement(['WAITING', 'RECEIVED']),
            'beneficiary_company_id' => $beneficiary_company->id,
            'emitter_company_id'     => $emitter_company->id,
        ];
    }
}
