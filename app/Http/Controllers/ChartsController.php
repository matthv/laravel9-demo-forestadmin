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
                'limit'   => 100,
            ]
        );

        foreach ($charges as $charge) {
            $country = $charge->source?->country ?: 'Others';

            if (!isset($repartition[$country])) {
                $repartition[$country] = ['key' => $country, 'value' => 1];
            } else {
                $repartition[$country]['value']++;
            }
        }

        return ChartApi::renderPie(array_values($repartition));
    }

    public function chargesPerDay()
    {
        $values = [];
        $from = new \DateTime('2022-01-01');
        $to = new \DateTime('2022-02-01');

        $stripe = new StripeClient('sk_test_4eC39HqLyjWDarjtT1zdp7dc'); //sk_AABBCCDD11223344
        $charges = $stripe->charges->all(
            [
                'created' => [
                    'gte' => $from->getTimestamp(),
                    'lte' => $to->getTimestamp(),
                ],
                'limit'   => 100,
            ]
        );

        foreach ($charges as $charge) {
            $date = \DateTime::createFromFormat('U', $charge->created)->format('d/m/Y');

            if (!isset($values[$date])) {
                $values[$date] = ['label' => $date, 'values' => ['value' => 1]];
            } else {
                $values[$date]['values']['value']++;
            }
        }

        return ChartApi::renderLine(array_values($values));
    }

    public function someObjective()
    {
        $data = [
            'value'     => 10, // the fetched value
            'objective' => 678, // the fetched objective
        ];

        return ChartApi::renderObjective($data);
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
