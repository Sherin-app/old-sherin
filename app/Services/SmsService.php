<?php

namespace App\Services;
use App\Models\CampaignHistorique;
use Illuminate\Support\Carbon;

class SmsService
{


    public function sendSms($data)
    {
        $url = 'https://bulksms.ma/developer/sms/send';
        foreach ($data as $el) {
            $num  = "0663423733";
            $texte = 'hello ';
            $emetteur = 'Morino';
            $fields_string = 'token=a4B2EZpCjP72JwA33JRTwYQ1e&tel=' . $num . '&message=' . urlencode($texte) . '&shortcode=' . $emetteur;
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

            $result = curl_exec($ch);

            curl_close($ch);
        }
    }
    
    
    
    public static function countSms($stores_id)
    {
        $sum = 0;
        $camps = CampaignHistorique::whereIn('store_id',$stores_id)->where('is_payed',0)->get();
       
        foreach($camps as $camp)
        {
            if(!in_array($camp->status,[0,4]))
            {
                $sum = $sum + $camp->status;
            }
            if($camp->status==4){
                $sum = $sum + 3;
            }
        }
        
        return $sum;
        
    }

    public function countSmsOfThisMonth($storesId){
        $sum = 0;
        $camps = CampaignHistorique::whereIn('store_id',$storesId)
        ->whereMonth('created_at', Carbon::now()->month)
        ->get();
        foreach($camps as $camp)
        {
            if(!in_array($camp->status,[0,4]))
            {
                $sum = $sum + $camp->status;
            }
            if($camp->status==4){
                $sum = $sum + 3;
            }
        }
        return $sum;
    }
}
