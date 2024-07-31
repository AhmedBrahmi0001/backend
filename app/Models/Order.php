<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
     protected $fillable = [
        'code',
        'delivered_date',
        'pickup_address',
        'deliver_address',
        'quantity',
        'description',
        'price',
        'etat',
        'client_id',
        'driver_id',
        'latitude_pickup_address',
        'longitude_pickup_address',
        'longitude_deliver_address',
        'latitude_deliver_address',

    ];
     public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
     public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
