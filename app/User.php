<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role','blocked_on'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // Soft Deletes Field
    protected $dates = ['deleted_at'];
    
    public function isBlocked()
    {
        if ( $this->blocked_on && Carbon::now() >= $this->blocked_on ) {
            return true;
        } else {
            return false;
        }
    }

    public function subscription()
    {
        return $this->hasOne('App\Subscription');
    }
}
