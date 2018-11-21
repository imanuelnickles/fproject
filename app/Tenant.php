<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tenant extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'tenant_id'; 

    protected $fillable = [
        'user_id','title', 'first_name', 'last_name','email','mobile','phone','dob','id_number','id_picture','address','notes'
    ];

    // Soft Deletes Field
    protected $dates = ['deleted_at'];
}
