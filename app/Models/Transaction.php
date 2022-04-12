<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class transaction
 */
class Transaction extends Model
{
    use HasFactory;

    /**
     * @return BelongsTo
     */
    public function beneficiaryCompany(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'beneficiary_company_id');
    }

    /**
     * @return BelongsTo
     */
    public function emitterCompany(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'emitter_company_id');
    }
}
