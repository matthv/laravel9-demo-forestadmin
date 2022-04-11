<?php

namespace App\Models;

use ForestAdmin\LaravelForestAdmin\Services\Concerns\ForestCollection;
use ForestAdmin\LaravelForestAdmin\Services\SmartFeatures\SmartAction;
use ForestAdmin\LaravelForestAdmin\Services\SmartFeatures\SmartRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Order
 *
 * @package  Laravel9-demo-forestadmin
 * @license  GNU https://www.gnu.org/licences/licences.html
 * @link     https://github.com/ForestAdmin/laravel-forestadmin
 */
class Order extends Model
{
    use HasFactory, ForestCollection;

    /**
     * @return SmartRelationship
     */
    public function deliveryAddress(): SmartRelationship
    {
        return $this->smartRelationship(
            [
                'type' => 'String',
                'reference' => 'address.id'
            ]
        )
            ->get(
                function () {
                    return Order::join('customers', 'customers.id', '=', 'orders.customer_id')
                        ->join('addresses', 'addresses.customer_id', '=', 'customers.id')
                        ->where('orders.id', $this->id)
                        ->first();
                }
            );
    }

    /**
     * @return SmartAction
     */
    public function refundOrder(): SmartAction
    {
        return $this->smartAction('single', 'refund order');
    }

    /**
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    /**
     * @return BelongsToMany
     */
    public function menus(): BelongsToMany
    {
        return $this->belongsToMany(Menu::class);
    }
}
