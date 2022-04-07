<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Bookstore;
use App\Models\Customer;
use ForestAdmin\LaravelForestAdmin\Http\Controllers\ForestController;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Class CustomersController
 */
class CustomersController extends ForestController
{
    /**
     * @return JsonResponse
     */
    public function chargeCreditCard(): JsonResponse
    {
        $customer = Customer::find(request()->input('data.attributes.ids')[0]);
        $stripe = new \Stripe\StripeClient(
            'sk_test_4eC39HqLyjWDarjtT1zdp7dc'
        );
        $response = $stripe->charges->create([
            'amount'      => request()->input('data.attributes.values.amount'),
            'currency'    => 'usd',
            'customer'    => $customer->stripe_id,
            'description' => request()->input('data.attributes.values.description'),
        ]);

        return response()->json(
            [
                'html' => '
                    <p class="c-clr-1-4 l-mt l-mb">'. $response->amount / 100 .' USD has been successfuly charged.</p>
    
                    <strong class="c-form__label--read c-clr-1-2">Credit card</strong>
                    <p class="c-clr-1-4 l-mb">**** **** **** '. $response->source->last4 .'</p>
                    
                    <strong class="c-form__label--read c-clr-1-2">Expire</strong>
                    <p class="c-clr-1-4 l-mb"> '. $response->source->exp_month .'/ '. $response->source->exp_year .'</p>
                    
                    <strong class="c-form__label--read c-clr-1-2">Card type</strong>
                    <p class="c-clr-1-4 l-mb">'. $response->source->brand .'</p>
                    
                    <strong class="c-form__label--read c-clr-1-2">Country</strong>
                    <p class="c-clr-1-4 l-mb">'. $response->source->country .'</p>
                '
            ]
        );
    }

    /**
     * @return BinaryFileResponse
     */
    public function generateInvoice()
    {
        return response()->download(public_path('files/invoice-2342.pdf'));
    }
}
