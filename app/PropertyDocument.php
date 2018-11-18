<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyDocument extends Model
{
    protected $primaryKey = 'property_document_id'; 

    protected $fillable = [
        'property_document_id','property_id', 'description','path','created_at','updated_at'
    ];
}
