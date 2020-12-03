<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'birthdate',
        'photo',
    ];

    protected $casts = [
        'birthdate' => 'date',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
