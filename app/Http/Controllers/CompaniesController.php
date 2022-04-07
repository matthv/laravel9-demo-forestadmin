<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Bookstore;
use App\Models\Company;
use ForestAdmin\LaravelForestAdmin\Http\Controllers\ResourcesController;
use ForestAdmin\LaravelForestAdmin\Http\Controllers\ForestController;
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

    /**
     * @return JsonResponse|Response
     */
    public function markAsLive(): JsonResponse|Response
    {

        $id = request()->input('data.attributes.ids')[0];
        $company = Company::findOrFail($id);
        $company->status = 'live';
        $company->save();

//        return response()->noContent();
//        return response()->json(['success' => "Company is now live !"]);
        return response()->json(['error' => "The company was already live!"], 400);
    }

    /**
     * @return JsonResponse
     */
    public function returnAndTrack(): JsonResponse
    {
        return response()->json(
            [
                'success' => 'Return initiated successfully.',
                'redirectTo' => 'https://www.royalmail.com/portal/rm/track?trackNumber=ZW924750388GB'
            ]
        );
    }

    /**
     * @return JsonResponse
     */
    public function showSomeActivity(): JsonResponse
    {
        return response()->json(
            [
                'success' => 'Return initiated successfully.',
                'redirectTo' => '/MyProject/MyEnvironment/MyTeam/data/20/index/record/20/108/activity'
            ]
        );
    }
}
