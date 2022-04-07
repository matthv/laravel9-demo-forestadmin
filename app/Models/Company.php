<?php

namespace App\Models;

use ForestAdmin\LaravelForestAdmin\Services\Concerns\ForestCollection;
use ForestAdmin\LaravelForestAdmin\Services\SmartFeatures\SmartAction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Company
 */
class Company extends Model
{
    use HasFactory, ForestCollection;

    /**
     * @return SmartAction
     */
    public function returnAndTrack(): SmartAction
    {
        return $this->smartAction('single', 'Return and track');
    }

    /**
     * @return SmartAction
     */
    public function showSomeActivity(): SmartAction
    {
        return $this->smartAction('single', 'Show some activity');
    }

    /**
     * @return SmartAction
     */
    public function markAsLive(): SmartAction
    {
        return $this->smartAction('single', 'Mark as Live');
    }

    /**
     * @return SmartAction
     */
    public function UploadLegalDocs(): SmartAction
    {
        return $this->smartAction('single', 'Upload Legal Docs')
            ->addField(
                [
                    'field' => 'Certificate of Incorporation',
                    'type' => 'File',
                    'is_required' => true,
                    'description' => 'The legal document relating to the formation of a company or corporation.'
                ]
            )
            ->addField(
                [
                    'field' => 'Proof of address',
                    'type' => 'File',
                    'is_required' => false,
                    'description' => '(Electricity, Gas, Water, Internet, Landline & Mobile Phone Invoice / Payment Schedule) no older than 3 months of the legal representative of your company'
                ]
            )
            ->addField(
                [
                    'field' => 'Company bank statement',
                    'type' => 'File',
                    'is_required' => true,
                    'description' => 'PDF including company name as well as IBAN'
                ]
            )
            ->addField(
                [
                    'field' => 'Valid proof of ID',
                    'type' => 'File',
                    'is_required' => true,
                    'description' => 'ID card or passport if the document has been issued in the EU, EFTA, or EEA / ID card or passport + resident permit or driving licence if the document has been issued outside the EU, EFTA, or EEA of the legal representative of your company'
                ]
            );
    }
}
