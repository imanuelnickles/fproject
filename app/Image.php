<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $primaryKey = 'image_id'; 

    protected $fillable = [
        'image_id','property_id','path','created_at','updated_at'
    ];
}
