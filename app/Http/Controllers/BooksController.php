<?php

namespace App\Http\Controllers;

use ForestAdmin\LaravelForestAdmin\Facades\JsonApi;
use ForestAdmin\LaravelForestAdmin\Http\Controllers\ResourcesController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class BooksController extends ResourcesController
{
    public function callAction($method, $parameters)
    {
        $parameters['collection'] = 'Book';
        return parent::callAction($method, $parameters);
    }

    public function count(): JsonResponse
    {
        if (Auth::guard('forest')->user()->getAttribute('team') === 'Operations') {
            return JsonApi::deactivateCountResponse();
        } else {
            return parent::count();
        }
    }
}
