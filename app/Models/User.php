<?php

namespace App\Models;

use ForestAdmin\LaravelForestAdmin\Services\Concerns\ForestCollection;
use ForestAdmin\LaravelForestAdmin\Services\SmartFeatures\SmartField;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Model
{
    use HasFactory;
    use ForestCollection;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
    ];

    /**
     * @return SmartField
     */
    public function company(): SmartField
    {
        return $this->smartField(['type' => 'String', 'is_filterable' => true])
            ->get(function() {
                $company = Company::whereHas('departments', fn($query) => $query->where('departments.id', $this->department->id))->first();
                return $company->name;
            })
            ->filter(
                function (Builder $query, $value, string $operator, string $aggregator) {
                    switch ($operator) {
                        case 'equal':
                            $query
                                ->whereIn('users.id', function ($q) use ($value, $aggregator) {
                                    return $q
                                        ->select('users.id')
                                        ->from('companies')
                                        ->join('departments', 'departments.company_id', '=', 'companies.id')
                                        ->join('users', 'users.department_id', '=', 'departments.id')
                                        ->whereRaw("LOWER (companies.name) LIKE LOWER(?)", ['%' . $value . '%'], $aggregator);
                                });
                            break;
                        default:
                            throw new ForestException(
                                "Unsupported operator: $operator"
                            );
                    }

                    return $query;
                }
            );
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
