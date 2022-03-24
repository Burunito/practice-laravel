<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];

    protected $hidden = ['created_at', 'updated_at', 'id'];
    protected $appends = ['key'];
    public function getNameAttribute($value)
    {
        return strtoupper($value);
    }
    public function getKeyAttribute()
    {
        return $this->id;
    }
}
