<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Energy Usage Model
 */
class EnergyUsage extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * @var string[]
     */
    protected $fillable = [
        'installation_id',
        'energy_produced',
        'energy_consumed',
        'date'
    ];

    /**
     * @return BelongsTo
     */
    public function installation(): BelongsTo
    {
        return $this->belongsTo(Installation::class);
    }
}
