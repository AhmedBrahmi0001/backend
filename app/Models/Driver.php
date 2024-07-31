<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'place_id',
        'name',
        'price',
        'image',
        'rating'
    ];
    protected $with = [
        'user'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function evaluations() {
        return $this->hasMany(Evaluation::class);
    }

    public function place()
    {
        return $this->belongsTo(Place::class, 'place_id');
    }
}
