<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penalty extends Model
{
    use HasFactory;

    protected $fillable = [
        'penaltyType',
        'amount',
    ];

    public function penaltiesDrivers()
    {
        return $this->hasMany(PenaltiesDrivers::class, 'penalty_id');
    }
}
