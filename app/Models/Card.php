<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = [
        'license_id',
        'cardNumber',
        'secret',
        'programmedDate',
    ];
}
