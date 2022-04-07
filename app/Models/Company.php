<?php

namespace App\Models;

use ForestAdmin\LaravelForestAdmin\Services\Concerns\ForestCollection;
use ForestAdmin\LaravelForestAdmin\Services\SmartFeatures\SmartAction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Company
 *
 * @package  Laravel9-demo-forestadmin
 * @license  GNU https://www.gnu.org/licences/licences.html
 * @link     https://github.com/ForestAdmin/laravel-forestadmin
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
}
