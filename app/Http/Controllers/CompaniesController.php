<?php

namespace App\Http\Controllers;

use ForestAdmin\LaravelForestAdmin\Http\Controllers\ResourcesController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Class CompaniesController
 */
class CompaniesController extends ResourcesController
{
    public function callAction($method, $parameters)
    {
        $parameters['collection'] = 'Company';
        return parent::callAction($method, $parameters);
    }

    public function index()
    {
        request()->query->add(['searchExtended' => '1']);
        return parent::index();
    }

    public function count(): JsonResponse
    {
        request()->query->add(['searchExtended' => '1']);
        return parent::count();
    }

    public function destroy(): JsonResponse
    {
        if (request()->route()->parameter('id') === "50") {
            return response()->json(['error' => 'This record is protected, you cannot remove it.'],Response::HTTP_FORBIDDEN);
        } else {
            return parent::destroy();
        }
    }
}
