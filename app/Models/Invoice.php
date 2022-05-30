<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    public $timestamps=false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','store_id','employ_id','promotion_price','description' ,'store_id','customer_id','invoice_date','total','montant_paye','mode_payment','points','for_sexe'
    ];

    public function customer(){
        return $this->belongsTo('App\Models\Customer','customer_id','id');
    }

    public function items()
    {
        return $this->hasMany('App\Models\InvoiceProduct','invoice_id');
    }

    public function store(){
        return $this->belongsTo('App\Models\Store','store_id','id');
    }

    public function employer(){
        return $this->belongsTo('App\User','employ_id','id');
    }
    
}
