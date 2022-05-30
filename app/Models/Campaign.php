<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    public $timestamps=false;
    
    protected $fillable = [
        'campaign_name','nature_sending' ,'message', 'create_date','template_id'
    ];

    public function template(){
        return $this->belongsTo('App\Models\Template','template_id');
    }

}
