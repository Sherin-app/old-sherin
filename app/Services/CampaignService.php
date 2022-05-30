<?php
namespace App\Services;

use App\Models\Campaign;
use App\Models\CampaignHistorique;
use Illuminate\Support\Facades\Log;
use App\Models\Store;

class CampaignService
{


    public function getCampaignHistoriqueByCodeAndCustomerId(string $code, string $customerId){
        $campaignHistory = CampaignHistorique::where('code_red','=',$code)->where('customer_id','=',$customerId)->where('expired_code','=',0)->first();
        if($campaignHistory){

            if(date('Y-m-d', strtotime($campaignHistory->start_date. ' + 8 days')) >= date('Y-m-d'))
            {
                return response()->json(['success'=>1,'code'=>'0.1']);
            }else{
                return response()->json(['success'=>0,'message'=>'Vous pouvez pas utiliser ce code de reduction car il est expiré!']);
            }
        }else{
             return response()->json(['success'=>0,'message'=>'Code invalide']);
        }
    }
    /**
     * @param array $customers
     *
     * @return void
     */
    public function createCampaign($data)
    {
        if(count($data)){
            //create historique campaign that will contain the store id the users ids and
             foreach($data as $els)
            {
                
                $campaignHistorique = [];
                $campaignsHistorique = [];
                $customers = $els['customers'];
                 foreach($customers as $customer)
                {  
                    
                     $campaignHist = CampaignHistorique::where('customer_id','=',$customer->id)->where('status','=',0)->first();
                    if(!$campaignHist){
                        $campaignHistorique['camp_id']     = 1;
                        $campaignHistorique['type']        = 1;//bulk sending
                        $campaignHistorique['store_id']    = $els['store_id'];
                        $campaignHistorique['customer_id'] = $customer->id;
                        $campaignHistorique['phone']       = $customer->phone;
                        $campaignHistorique['start_date']  = $els['start_date'];
                        $campaignHistorique['code_red']    = $this->generateCode();
                        CampaignHistorique::Create($campaignHistorique);
                           
                    } 
                     
                }

            }
        }

    }
    
     public function generateCode($length = 6) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    
    private function formattMessage($nameCar='(Prénom)',$name='',$codeCar='******',$code='',$day='',$senderId){
        
        $message = str_replace($nameCar, $name , config('messages.'.$senderId.'.'.$day));
        Log::info('messages.'.$senderId.'.'.$day) ;
        Log::info('config message '.config('messages.'.$senderId.'.'.$day)) ;
 
        $message = str_replace($codeCar, $code , $message);
 
        return $message;
     }
    
    public function singleCampaign($data)
    {
        
          $campHistory =  CampaignHistorique::create([
                    'camp_id'     => null,
                    'store_id'    => $data['store_id'],
                    'customer_id' => null,//nullable
                    'phone'       => $data['phone'],
                    'start_date'  => $data['start_date'],
            ]);
            //sendSms service
            
            $this->sendSms($data['phone'],$data['message'],$data['sender']);

            //modify the status here
            $campHistory->status = 1;
            $campHistory->save();
            
            // return redirect('dashboard/owner');
    }

     private function sendSms($num = "0675295551",$texte ="hello hamza today ",$emetteur = "MORINO")
    {
            

            $url = 'https://bulksms.ma/developer/sms/send';
                                                                                                
        
            $fields_string = 'token=a4B2EZpCjP72JwA33JRTwYQ1e&tel=' . $num . '&message=' . urlencode($texte). '&shortcode=' . $emetteur;
            
            Log::info($fields_string);
            
            $ch = curl_init();
        
            curl_setopt($ch, CURLOPT_URL, $url);
           // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        
            $result = curl_exec($ch);
        
            curl_close($ch);
            Log::info($result);
            return $result; 


    }
    
    
    public function getTodayHistoriques()
    {

        return CampaignHistorique::where('status','=',0)->where('camp_id','=',1)->whereDate('start_date',Carbon::today())->get();

    }

    public function getLastDayFinishedCampaigns()
    {
       $result = CampaignHistorique::where('status','=',3)->where('camp_id','=',1)->get();
       foreach($result as $el)
        $el->update([
                'status' => 4
        ]);

    }

    public function getLastDayCampaigns()
    {
       return  CampaignHistorique::where('status','=',2)->where('camp_id','=',1)->get();
    }

    public function launchLastDayCampaigns($data)
    {
        $phones = '';
        $count = count($data);
        $i=0;
            foreach($data as $el)
            {
               $el->update(['status'=>3]);
               $senderId = Store::find($el['store_id'])->sender_id;
               $this->sendSms($el->phone,$this->formattMessage($nameCar='(Prénom)',($el->customer->lastname)?$el->customer->lastname:$el->customer->firstname,$codeCar='******',$el->code_red,$day='thirdDay',$senderId),$senderId);

            }
            
              
              // $this->sendSms($phones,'LastDay','MORINO');

            //send sms to this user
    }

    public function getSecondeDayCampaigns()
    {
        return  CampaignHistorique::where('status','=',1)->where('camp_id','=',1)->get();
    }

    public function launchSecondeDayCampaigns($data)
    {
             $phones='';
             $count = count($data);
             $i=0;
            foreach($data as $el)
            {
              $el->update(['status'=>2]);
              $senderId = Store::find($el['store_id'])->sender_id;
              $this->sendSms($el->phone,$this->formattMessage($nameCar='(Prénom)',($el->customer->lastname)?$el->customer->lastname:$el->customer->firstname,$codeCar='******',$el->code_red,$day='secondeDay',$senderId),$senderId);

            }
            //send sms to this user
    }

    public function getFirstDayCampaigns()
    {
        return  CampaignHistorique::where('status','=',0)->where('camp_id','=',1)->get();
    }
      public function launchFirstDayCampaigns($data)
    {
        
        foreach($data as $el)
        {
           
               $el->update(['status'=>1]);
               $senderId = Store::find($el['store_id'])->sender_id;
               $this->sendSms($el->phone,$this->formattMessage($nameCar='(Prénom)',($el->customer->lastname)?$el->customer->lastname:$el->customer->firstname,$codeCar='******',$el->code_red,$day='firstDay',$senderId),$senderId);

        }
      

    }



}
