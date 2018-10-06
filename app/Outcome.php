<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Outcome extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'outcome_id'; 

    protected $fillable = [
        'property_id','user_id','name','payment_date','amount','status','created_at','updated_at'
    ];

    // Soft Deletes Field
    protected $dates = ['deleted_at'];
}
