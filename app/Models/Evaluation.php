<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;


    protected $fillable = [
        'driver_id',
        'client_id',
        'comment',
        'rating',
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

     public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
