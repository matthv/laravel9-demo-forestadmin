<?php

namespace App\Http\Controllers;

use ForestAdmin\LaravelForestAdmin\Facades\JsonApi;
use ForestAdmin\LaravelForestAdmin\Http\Controllers\RelationshipsController;
use Illuminate\Http\JsonResponse;

class BookCompaniesController extends RelationshipsController
{
    public function callAction($method, $parameters)
    {
        $parameters['collection'] = 'Book';
        $parameters['association_name'] = 'companies';
        return parent::callAction($method, $parameters);
    }

    public function count(): JsonResponse
    {
        if (request()->has('search')) {
            return JsonApi::deactivateCountResponse();
        } else {
            return parent::count();
        }
    }
}
