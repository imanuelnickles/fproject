<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'payment_id'; 

    protected $fillable = [
        'tenant_id','payment_term_id', 'payment_type', 'amount','payment_date','notes'
    ];

    // Soft Deletes Field
    protected $dates = ['deleted_at'];

    public function paymentTerm(){
        return $this->belongsTo('App\PaymentTerm','payment_term_id');
    }
}
