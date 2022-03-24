<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZoneType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];
    protected $hidden = ['created_at', 'updated_at'];
    public function getNameAttribute($value)
    {
        return strtoupper($value);
    }
}
