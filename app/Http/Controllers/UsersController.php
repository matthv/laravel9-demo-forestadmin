<?php

namespace App\Http\Controllers;

use App\Models\User;
use ForestAdmin\LaravelForestAdmin\Facades\JsonApi;
use ForestAdmin\LaravelForestAdmin\Http\Controllers\ResourcesController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class UsersController extends ResourcesController
{
    public function callAction($method, $parameters)
    {
        $parameters['collection'] = 'User';
        return parent::callAction($method, $parameters);
    }

    public function store(): JsonResponse
    {
        $this->authorize('create', $this->model);
        $response = Http::post('https://<your-api>/users', request()->all())->json();
        $user = User::findOrFail($response['id']);

        return response()->json(JsonApi::render($user, $this->name), Response::HTTP_CREATED);
    }
}
