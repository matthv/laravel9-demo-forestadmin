<?php

namespace App\Models\SmartCollections;

use ForestAdmin\LaravelForestAdmin\Services\SmartFeatures\SmartCollection;
use ForestAdmin\LaravelForestAdmin\Services\SmartFeatures\SmartField;
use Illuminate\Support\Collection;

class CustomerStat extends SmartCollection
{
    protected string $name = 'customerStat';

    protected bool $is_searchable = true;

    protected bool $is_read_only = true;

    /**
     * @return Collection
     */
    public function fields(): Collection
    {
        return collect(
            [
                new SmartField(
                    [
                        'field' => 'id',
                        'type'  => 'Number',
                    ]
                ),
                new SmartField(
                    [
                        'field' => 'email',
                        'type'  => 'String',
                    ]
                ),
                new SmartField(
                    [
                        'field' => 'orders_count',
                        'type'  => 'Number',
                    ]
                ),
                new SmartField(
                    [
                        'field' => 'total_count',
                        'type'  => 'Number',
                    ]
                ),
            ]
        );
    }
}
