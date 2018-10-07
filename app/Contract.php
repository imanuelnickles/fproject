<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'contract_id'; 

    protected $fillable = [
        'contract_id',
        'property_id',
        'tenant_id',
        'start_date',
        'end_date',
        'contract_date',
        'notes'
    ];

    // Soft Deletes Field
    protected $dates = ['deleted_at'];
}
