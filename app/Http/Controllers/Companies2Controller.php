<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Transaction;
use Faker\Factory;
use Faker\Generator;
use ForestAdmin\LaravelForestAdmin\Http\Controllers\ForestController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

/**
 * Class Companies2Controller
 */
class Companies2Controller extends ForestController
{
    /**
     * @return JsonResponse
     */
    public function addNewTransaction(): JsonResponse
    {
        $faker = Factory::create();

        $emitter_company_id = request()->input('data.attributes.ids')[0];
        $beneficiary_company_id = request()->input('data.attributes.values.Beneficiary company');
        $amount = request()->input('data.attributes.values.Amount');

        $transaction = new Transaction();
        $transaction->beneficiary_iban = $faker->iban();
        $transaction->emitter_iban = $faker->iban();
        $transaction->vat_amount = 20;
        $transaction->amount = $amount;
        $transaction->fee_amount = $faker->numberBetween(10, 100);
        $transaction->note = '';
        $transaction->emitter_bic = $faker->swiftBicNumber();
        $transaction->beneficiary_bic = $faker->swiftBicNumber();
        $transaction->reference = $faker->text(16);
        $transaction->status = 'WAITING';
        $transaction->beneficiary_company_id = $beneficiary_company_id;
        $transaction->emitter_company_id = $emitter_company_id;
        $transaction->save();

        // the code below automatically refresh the related data
        // 'emitted_transactions' on the Companies' Summary View
        // after submitting the Smart action form.
        return response()->json(
            [
                'success' => 'New transaction emitted',
                'refresh' => ['relationships' => ['emittedTransaction']]
            ]
        );
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

    /**
     * @return JsonResponse
     */
    public function uploadLegalDocs()
    {
        $companyId = request()->input('data.attributes.ids')[0];
        $files = request()->input('data.attributes.values');
        foreach ($files as $key => $file)
        {
            $data = explode(";base64,", $file);
            Storage::disk('s3')->put($key . '-' . $companyId, base64_decode($data[1]));
        }

        return response()->json(
            [
                'success' => 'Legal documents are successfully uploaded.',
            ]
        );
    }
}
