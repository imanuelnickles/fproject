<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentTerm extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'payment_term_id'; 

    protected $fillable = [
        'payment_term_id', 'contract_id', 'deadline', 'payment_date', 'amount'
    ];

    // Soft Deletes Field
    protected $dates = ['deleted_at'];

    public function contract(){
        return $this->belongsTo('App\Contract','contract_id');
    }

    public function payment(){
        return $this->hasMany('App\Payment','payment_term_id');
    }
}
