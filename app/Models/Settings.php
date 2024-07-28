<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    protected $table = 'settings';

    protected $fillable = [
        'name',
        'data',
        'status',
        'created_by',
    ];

    protected function getDataAttribute()
    {
        return !is_null($this->attributes['data']) ? unserialize($this->attributes['data']) : null;
    }
}
