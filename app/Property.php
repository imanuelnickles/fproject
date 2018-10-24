<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'property_id'; 

    protected $fillable = [
        'property_id','user_id','name', 'address', 'country','city','post_code','property_type','total_floor',
        'total_bedrooms','building_area','surface_area', 'purchase_date',
        'purchase_price', 'tax', 'valuation', 'rent_price', 'occupied', 'notes'
    ];

    // Soft Deletes Field
    protected $dates = ['deleted_at'];

    public function expenses(){
        return $this->hasMany('App\Outcome','property_id');
    }

    public function contracts(){
        return $this->hasMany('App\Contract','property_id');
    }
}