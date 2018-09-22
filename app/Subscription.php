<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $primaryKey = 'subscription_id';   
    protected $fillable = [
        'user_id', 'start_date', 'end_date'
    ];
}
