<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceProduct extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'invoice_id', 'product_id','qte','price'
    ];
    
    public $timestamps=false;

    public function product(){
        return $this->belongsTo('App\Models\Product','product_id');
    }
}
