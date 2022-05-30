<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
     
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','activity_id','logo','sender_id' ,'name','contact','phone','address','base','base_profit','coeff','tva','invoice_message'
    ];

    public function owner()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }

    public function activity()
    {
        return $this->belongsTo('App\Models\Activity');
    }

    public function invoices(){
        return $this->hasMany('App\Models\Invoice','store_id');
    }
}
