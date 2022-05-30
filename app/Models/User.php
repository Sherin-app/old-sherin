<?php

namespace App\Models;

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
        'firstname','lastname' ,'email', 'password', 'phone','is_admin','store_id','is_active','updated_at','created_at'
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
     return $this->firstname . " " . $this->lastname;	 	 
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
