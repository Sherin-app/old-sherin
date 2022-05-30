<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
     public $timestamps=false;
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'label','price', "store_id",'quantite','promotion_price','menu_id','image'
    ];

      /**
     * Get The current product category.
     */
    public function store()
    {
        return $this->belongsTo('App\Models\Store','store_id');
    }
    
    public function invoicesProduct(){
        return $this->hasMany('App\Models\InvoiceProduct');
    }

    public function menu(){
        return $this->belongsTo(Menu::class,'menu_id');
    }
}
