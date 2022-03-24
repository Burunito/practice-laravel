<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settlement extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'postal_code_id',
        'settlement_type_id',
    ];
    
    protected $hidden = ['created_at', 'updated_at', 'postal_code_id', 'settlement_type_id'];
    public function municipaly(){
        return $this->belongsTo('App\Models\SettlementType', 'settlement_type_id');
    }

    public function postal_code(){
        return $this->belongsTo('App\Models\PostalCode', 'postal_code_id');
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => strtoupper($value),
        );
    }
}
