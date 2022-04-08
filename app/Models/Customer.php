<?php

namespace App\Models;

use ForestAdmin\LaravelForestAdmin\Services\Concerns\ForestCollection;
use ForestAdmin\LaravelForestAdmin\Services\SmartFeatures\SmartAction;
use ForestAdmin\LaravelForestAdmin\Services\SmartFeatures\SmartField;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Customer
 */
class Customer extends Model
{
    use HasFactory, ForestCollection;

    /**
     * @return SmartField
     */
    public function fullname(): SmartField
    {
        return $this->smartField(['type' => 'String'])
            ->get(fn() => $this->firstname . ' ' . $this->lastname)
            ->set(
                function ($value) {
                    [$firstname, $lastname] = explode(' ', $value);
                    $this->firstname = $firstname;
                    $this->lastname = $lastname;

                    return $this;
                }
            )
            ->search(
                function (Builder $query, $value) {
                    [$firstname, $lastname] = explode(' ', $value);
                    return $query->orWhere(
                        fn($query) => $query->where('firstname', $firstname)
                            ->where('lastname', $lastname)
                    );
                }
            )
            ->filter(
                function (Builder $query, $value, string $operator, string $aggregator) {
                    $data = explode(' ', $value);
                    switch ($operator) {
                        case 'equal':
                            $query->where(
                                fn($query) => $query->where('firstname', $data[0])
                                    ->where('lastname', $data[1]),
                                null,
                                null,
                                $aggregator
                            );
                            break;
                        case 'ends_with':
                            if ($data[1] === null) {
                                $query->where(
                                    fn($query) => $query->whereRaw("lastname LIKE ?", ['%' . $data[0] . '%']),
                                    null,
                                    null,
                                    $aggregator
                                );
                            } else {
                                $query->where(
                                    fn($query) => $query->whereRaw("firstname LIKE ?", ['%' . $value . '%'])
                                        ->whereRaw("lastname LIKE ?", ['%' . $value . '%']),
                                    null,
                                    null,
                                    $aggregator
                                );
                            }
                            break;
                       //... And so on with the other operators not_equal, starts_with, etc.
                        default:
                            throw new ForestException(
                                "Unsupported operator: $operator"
                            );
                    }

                    return $query;
                }
            );
    }

    /**
     * @return SmartField
     */
    public function fullAddress(): SmartField
    {
        return $this->smartField(['type' => 'String'])
            ->get(
                function () {
                    $address = Address::firstWhere('customer_id', $this->id);

                    return "$address->address_line1  $address->address_line2 $address->address_city  $address->country";
                }
            );
    }

    /**
     * @return SmartAction
     */
    public function someAction(): SmartAction
    {
        return $this->smartAction('bulk', 'Some action')
            ->addField(
                [
                    'field' => 'country',
                    'type' => 'String',
                    'is_read_only' => true,
                ]
            )
            ->addField(
                [
                    'field' => 'city',
                    'type' => 'String',
                ]
            )
            ->load(
                function () {
                    $customerCountries = Customer::select('country')
                        ->whereIn('id', request()->input('data.attributes.ids'))
                        ->groupBy('country')
                        ->get();

                    $fields = $this->getFields();
                    $fields['country']['value'] = '';
                    $fields['stripe_id']['is_read_only'] = false;

                    if ($customerCountries->count() === 1) {
                        $fields['country']['value'] = $customerCountries->first()->country;
                        $fields['stripe_id']['is_read_only'] = true;
                    }

                    return $fields;
                }
            );
    }

    /**
     * @return SmartAction
     */
    public function generateInvoice(): SmartAction
    {
        return $this->smartAction('single', 'Generate invoice')
            ->download(true);
    }

    /**
     * @return SmartAction
     */
    public function chargeCreditCard(): SmartAction
    {
        return $this->smartAction('single', 'Charge credit card')
            ->addField(
                [
                    'field' => 'amount',
                    'type' => 'Number',
                    'is_required' => true,
                    'description' => 'The amount (USD) to charge the credit card. Example: 42.50'
                ]
            )
            ->addField(
                [
                    'field' => 'description',
                    'type' => 'String',
                    'is_required' => true,
                    'description' => 'Explain the reason why you want to charge manually the customer here'
                ]
            )
            ->addField(
                [
                    'field' => 'stripe_id',
                    'type' => 'String',
                    'is_required' => true,
                ]
            )
            ->load(
                function () {
                    $customer = Customer::find(request()->input('data.attributes.ids')[0]);
                    $fields = $this->getFields();
                    $fields['amount']['value'] = 4250;
                    $fields['stripe_id']['value'] = $customer->stripe_id;

                    return $fields;
                }
            );
    }

    /**
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
