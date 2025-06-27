<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $fillable = [
        'sale_id',
        'type',
        'amount',
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
