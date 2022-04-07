<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Bookstore;
use ForestAdmin\LaravelForestAdmin\Http\Controllers\ForestController;
use Illuminate\Http\JsonResponse;

/**
 * Class OrdersController
 */
class OrdersController extends ForestController
{
    /**
     * @return JsonResponse
     */
    public function refundOrder(): JsonResponse
    {
        dd(request());
        return response()->json(
            ['success' => 'Order refunded!']
        );
    }
}
