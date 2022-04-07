<?php

namespace App\Http\Controllers;

use Faker\Factory;
use ForestAdmin\LaravelForestAdmin\Facades\ChartApi;
use Stripe\StripeClient;

class ChartsController extends Controller
{
    public function mrr()
    {
        $mrr = 0;
        $stripe = new StripeClient('sk_test_4eC39HqLyjWDarjtT1zdp7dc'); //sk_AABBCCDD11223344
        $charges = $stripe->charges->all(['limit' => 3]);
        foreach ($charges as $charge) {
            $mrr += $charge->amount;
        }

        return ChartApi::renderValue($mrr);
    }

    public function creditCardCountryRepartition()
    {
        $repartition = [];
        $from = new \DateTime('2022-01-01');
        $to = new \DateTime('2022-04-04');

        $stripe = new StripeClient('sk_test_4eC39HqLyjWDarjtT1zdp7dc'); //sk_AABBCCDD11223344
        $charges = $stripe->charges->all(
            [
                'created' => [
                    'gte' => $from->getTimestamp(),
                    'lte' => $to->getTimestamp(),
                ],
                'limit' => 100,
            ]
        );
        dd($charges);
       /* $from = Date.parse('2018-03-01').to_time(:utc).to_i
        $to = Date.parse('2018-03-20').to_time(:utc).to_i*/
    }

    public function createCharges()
    {
        $faker = Factory::create();
        $stripe = new StripeClient('sk_test_4eC39HqLyjWDarjtT1zdp7dc');
        foreach ([2000, 1500, 1000, 500] as $amount) {
            $stripe->charges->create([
                'amount'      => $amount,
                'currency'    => 'eur',
                'source'      => 'tok_amex',
                'description' => $faker->name,
            ]);
        }
    }
}
