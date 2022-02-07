<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['meet_id', 'name', 'meet_date', 'start', 'end'];

    public function meet()
    {
        return $this->hasMany(Meet::class);
    }
}
