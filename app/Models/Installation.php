<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Installation Model
 */
class Installation extends Model
{
    public $timestamps = false;
    /**
     * @var string[]
     */
    protected $fillable = ['name', 'color'];

    /**
     * @return HasMany
     */
    public function energyUsages(): HasMany
    {
        return $this->hasMany(EnergyUsage::class);
    }
}
