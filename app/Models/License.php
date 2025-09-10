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
        'dateLieuDelivrance',
        'licensesAllowed',
        'allowedCategories',
    ];

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class, 'driverId');
    }

    public function card(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Card::class, 'license_id');
    }

    public function penalties()
    {
        return $this->hasMany(\App\Models\PenaltiesDrivers::class, 'license_id', 'id');
    }
}
