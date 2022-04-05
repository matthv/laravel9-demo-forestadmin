<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class ChefAvailability
 *
 * @package  Laravel9-demo-forestadmin
 * @license  GNU https://www.gnu.org/licences/licences.html
 * @link     https://github.com/ForestAdmin/laravel-forestadmin
 */
class ChefAvailability extends Model
{
    use HasFactory;

    /**
     * @return BelongsTo
     */
    public function chef(): BelongsTo
    {
        return $this->belongsTo(Chef::class);
    }
}
