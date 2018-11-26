<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContractTemplate extends Model
{
    protected $primaryKey = 'contract_template_id'; 

    protected $fillable = [
        'user_id','contract_template'
    ];
}
