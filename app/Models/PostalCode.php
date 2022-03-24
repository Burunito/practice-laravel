<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Locality;

class PostalCode extends Model
{
    use HasFactory;
    protected $fillable = [
        'zip_code',
        'locality_id',
        'federal_entity_id',
        'municipality_id',
    ];

    protected $appends = ['locality'];
    protected $hidden = ['created_at', 'updated_at', 'locality_id', 'federal_entity_id','municipality_id'];
    public function locality(){
        return $this->belongsTo('App\Models\Locality', 'locality_id');
    }
    public function federal_entity(){
        return $this->belongsTo('App\Models\FederalEntity', 'federal_entity_id');
    }
    public function municipality(){
        return $this->belongsTo('App\Models\Municipality', 'municipality_id');
    }
    public function settlements(){
        return $this->hasMany('App\Models\Settlement', 'postal_code_id');
    }
    public function getLocalityAttribute($value)
    {
        return Locality::find($this->locality_id)->name;
    }
}
