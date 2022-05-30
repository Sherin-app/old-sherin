<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{   
 
    
    protected $fillable = [
        'firstname','lastname' ,'email', 'phone', 'birth','sexe','store_id','user_id','created_at','updated_at'
    ];

    public function store()
    {
        return $this->belongsTo('App\Models\Store','store_id');
    }

    public function getFullNameAttribute()	 	 
    {	 	 
     return $this->firstname . " " . $this->lastname;	 	 
    }

    public function invoices(){
        return $this->hasMany('App\Models\Invoice','customer_id');
    }
}
