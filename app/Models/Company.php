<?php

namespace App\Models;

use ForestAdmin\LaravelForestAdmin\Services\Concerns\ForestCollection;
use ForestAdmin\LaravelForestAdmin\Services\SmartFeatures\SmartAction;
use ForestAdmin\LaravelForestAdmin\Services\SmartFeatures\SmartActionField;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    /**
     * @return SmartAction
     */
    public function sendInvoice(): SmartAction
    {
        return $this->smartAction('single', 'Send invoice')
            ->addField(
                [
                    'field' => 'country',
                    'type' => 'Enum',
                    'enums' => [],
                ]
            )
            ->addField(
                [
                    'field' => 'city',
                    'type' => 'String',
                    'hook' => 'onCityChange',
                ]
            )
            ->addField(
                [
                    'field' => 'zipCode',
                    'type' => 'String',
                    'hook' => 'onZipCodeChange',
                ]
            )
            ->load(
                function () {
                    $fields = $this->getFields();
                    $fields['country']['enums'] = Company::getEnumsFromDatabaseForThisRecord();

                    return $fields;
                }
            )
            ->change(
                [
                    'onCityChange' => function () {
                        $fields = $this->getFields();
                        $fields['zipCode']['value'] = Company::getZipCodeFromCity($fields['city']['value']);
                        $fields['another field'] = (new SmartActionField(
                            [
                                'field' => 'another field',
                                'type'  => 'Boolean',
                                'hook'  => 'onAnotherFiledChanged'
                            ]
                        ))
                            ->serialize();
                        return $fields;
                    },
                    'onAnotherFiledChanged' => function () {
                        $fields = $this->getFields();
                        // Do what you want

                        return $fields;
                    },
                    'onZipCodeChange' => function () {
                        $fields = $this->getFields();
                        $fields['city']['value'] = Company::getCityFromZipCode($fields['zipCode']['value']);

                        return $fields;
                    },
                ]
            );
    }

    /**
     * @return string[]
     */
    public static function getEnumsFromDatabaseForThisRecord(): array
    {
        return ['France', 'Germany', 'USA'];
    }

    /**
     * @param string $zipCode
     * @return string
     */
    public static function getCityFromZipCode(string $zipCode): string
    {
        return "City for $zipCode";
    }

    /**
     * @param string $city
     * @return string
     */
    public static function getZipCodeFromCity(string $city): string
    {
        return "Zip code for $city";
    }

    /**
     * @return HasMany
     */
    public function departments(): HasMany
    {
        return $this->hasMany(Department::class);
    }
}
