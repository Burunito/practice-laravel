<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ZoneType;

class Settlement extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'postal_code_id',
        'settlement_type_id',
        'zone_type_id',
    ];
    protected $appends = ['zone_type'];
    protected $hidden = ['created_at', 'updated_at', 'postal_code_id', 'settlement_type_id', 'zone_type_id', 'id'];
    public function settlement_type(){
        return $this->belongsTo('App\Models\SettlementType', 'settlement_type_id');
    }

    public function postal_code(){
        return $this->belongsTo('App\Models\PostalCode', 'postal_code_id');
    }
    public function zone_type(){
        return $this->belongsTo('App\Models\ZoneType', 'zone_type_id');
    }

    public function getNameAttribute($value)
    {
        return strtoupper($value);
    }

    public function getZoneTypeAttribute($value)
    {
        return ZoneType::find($this->zone_type_id)->name;
    }
}
