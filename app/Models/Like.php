<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sauce_id',
        'like'
    ];

    //Modele pivot
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sauce()
    {
        return $this->belongsTo(Sauce::class);
    }
}
