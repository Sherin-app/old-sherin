<?php

use App\Models\Store;
use App\User;
use Carbon\Carbon;

function getImageByModel($id, $directory, $image)
{
    return  $fullpath = "uploads/" . $directory . "/" . $id . "/" . $image;
}



function getInvoiceColorByStatus($status)
{
    switch ($status) {
        case '4':
            return '#bd59fa !important';
            break;
        case '2':
            return '#eb8c95 !important';
        default:
            return "green !important";
            break;
    }
}


function customerAvatar($sexe){
    switch ($sexe) {
        case '0':
           return asset('assets/images/avtar/h.png');
            break;

        case '1': 
            return asset('assets/images/avtar/f.png');
            break;
        
        default:
            # code...
            break;
    }
}



function getSexeMembre($sexe)
{
    if ($sexe == 1) {
        return "Femme";
    } else {
        return "Homme";
    }
}


function uploadFile($file, $membre_id, $directory)
{
    $destinationPath = 'uploads/' . $directory . "/" . $membre_id;
    // $fullpath="uploads/".$directory."/".$id."/".$image;
    //move each file to destination path
    $file->move($destinationPath, $file->getClientOriginalName());
}

function getPaiementMethod($id)
{
    switch ($id) {
        case '1':
           return trans('Espèces');
            break;
        case '2': 
            return trans('Chèque');
            break;
        case '3': 
            return trans('Carte Bancaire');
            break;
        default:
            # code...
            break;
    }
}

function convertToPoints( $points , $coeff)
{
    return  $points * $coeff;
}



function getInvoiceType($type)
{
    switch ($type) {
        case '0':
            return 'Pending';
            break;

        default:
            # code...
            break;
    }
}


function getSubtotal($quantity, $price)
{
    return $quantity * $price;
}


function bestSellerInfo($employ_id)
{
    $employ=User::find($employ_id);
   
    return $employ;
}

 function getInvoiceStatus($status){
     switch ($status) {
         case '0':
             return __('communs.Terminée');
             break;
         case '4':  
              return __('communs.Modifiée');
            break;
         case '2':  
                return __('communs.Annulée');
            break;
         default:
             # code...
             break;
     }
 }

 function calculateTurnOverByStore($invoices)
 {
     $ca=0;
     foreach($invoices as $item)
     {
         if($item->status==0){
            $ca=$ca+$item->total;
         }
     }
     return $ca;
 }
 
 
 function calculateTurnOverYesterdayByStore($invoices,$type){
     
     $ca_today = 0;
     $ca_yesterday = 0;
     $yesterday = date('Y-m-d',strtotime("-1 days"));
     $today     = date('Y-m-d'); 
     foreach($invoices as $invoice){
         
         if($invoice->status==0){
             if(Carbon::parse($invoice->invoice_date)->format('Y-m-d') == $today ){
              $ca_today = $ca_today + $invoice->total;
         }elseif(Carbon::parse($invoice->invoice_date)->format('Y-m-d') == $yesterday){
             $ca_yesterday = $ca_yesterday + $invoice->total;
         }
         }
         
     }
     
     if($type==0)
        return $ca_today;
    
    return $ca_yesterday;    
     
 }
 

 function getSendNature($id){
     switch ($id) {
         case '0':
                 return __('Unique');
             break;
         case '1' : 
                return __('Bulk');
             break;
         
         default:
             # code...
             break;
     }
 }

 function getCampaignStatus($status)
 {
     
    switch ($status) {
        case '0':
           return   __('Inactive');
            break;
        case '1':
            return  __('Active');
            break;
        default:
            # code...
            break;
    }
 }

 function getOperator($data=[],$key)
 {
    return $data[$key];
 }
