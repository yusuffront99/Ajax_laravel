<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'age',
        'gender'
    ];

    public function score()
    {
        return $this->belongsTo(Score::class);
    }
}
