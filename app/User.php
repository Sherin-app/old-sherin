<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname','lastname' ,'email', 'password', 'phone','is_admin','store_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getFullNameAttribute()	 	 
    {
        $name = ($this->firstname) ? $this->firstname : '';
        $lastname = ($this->lastname) ? $this->lastname : '';
     return $name.'-'.$lastname;	 	 
    }

    public function store()
    {
        return $this->belongsTo('App\Models\Store','store_id');
    }

    public function stores()
    {
        return $this->hasMany('App\Models\Store','user_id');
    }

   

}
