<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class License extends Model
{
    protected $fillable = [
        'driverId',
        'licenseNumber',
        'issueDate',
        'expiryDate',
        'plateNumber',
    ];

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class, 'driverId');
    }
}
