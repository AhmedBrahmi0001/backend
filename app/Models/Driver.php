<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;
    protected $fillable = [
        'place_id',
        'name',
        'price',
        'image',
        'rating'
    ];

    public function user()
    {
        return $this->morphOne('App\Models\User', 'userable')->without('userable');;
    }

    public function evaluations() {
        return $this->hasMany(Evaluation::class);
    }

    public function place()
    {
        return $this->belongsTo(Place::class, 'place_id');
    }
}
