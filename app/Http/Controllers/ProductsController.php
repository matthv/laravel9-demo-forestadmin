<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use ForestAdmin\LaravelForestAdmin\Facades\JsonApi;
use ForestAdmin\LaravelForestAdmin\Http\Controllers\ForestController;
use Illuminate\Http\JsonResponse;

/**
 * Class ProductsController
 */
class ProductsController extends ForestController
{
    /**
     * @param int $id
     * @return JsonResponse
     */
    public function buyers(int $id): JsonResponse
    {
        $query = Customer::whereHas('orders.products', fn ($query) => $query->where('products.id', $id))
            ->paginate($pageParams['size'] ?? null, '*', 'page', $pageParams['number'] ?? null);

        return response()->json(
            JsonApi::render($query, 'customers', ['count' => $query->total()])
        );
    }
}
