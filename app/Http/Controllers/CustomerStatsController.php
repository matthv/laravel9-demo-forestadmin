<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use ForestAdmin\LaravelForestAdmin\Facades\JsonApi;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CustomerStatsController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $query = Customer::select(DB::raw('customers.id, customers.email, COUNT(DISTINCT orders.*) AS orders_count, SUM(products.price) AS total_count'))
            ->join('orders', 'orders.customer_id', '=', 'customers.id')
            ->join('order_product', 'order_product.order_id', '=', 'orders.id')
            ->join('products', 'products.id', '=', 'order_product.product_id')
            ->groupBy('customers.id')
            ->orderBy('customers.id');

        if (request()->has('search')) {
            $query->whereRaw("LOWER (customers.email) LIKE LOWER(?)", ['%' . request()->input('search') . '%']);
        }

        $pageParams = request()->query('page') ?? [];

        $customerStats = $query->paginate(
            $pageParams['size'] ?? null,
            '*',
            'page',
            $pageParams['number'] ?? null
        );

        return response()->json(
            JsonApi::render($customerStats, 'customerStat',  ['count' => $customerStats->total()])
        );
    }
}
