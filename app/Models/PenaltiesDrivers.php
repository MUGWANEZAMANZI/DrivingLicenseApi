<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenaltiesDrivers extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_id',
        'penalty_id',
        'amount',
        'dateIssued',
        'isPaid',
    ];

    public function penalty()
    {
        return $this->belongsTo(Penalty::class, 'penalty_id');
    }
}
