<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Driver extends Model
{
    protected $fillable = [
        'name',
        'surName',
        'phone',
        'email',
        'address',
        'bloodGroup',
        'nationalId',
        'profileImage',
    ];

    public function license(): HasOne
    {
        return $this->hasOne(License::class, 'driverId');
    }
}
