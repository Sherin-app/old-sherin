<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Services\CustomerService;
use App\models\Store;
use App\Models\CampaignHistorique;
use App\User;
use App\Services\CampaignService;

use Carbon\Carbon;
class CustomerController extends Controller
{
    
    
    protected $campaignService;
    
    public function __construct(CampaignService $campaignService)
    {
        $this->campaignService = $campaignService;
    }
    
    
    public function getCustomersTarget(){
        
        
        // $message = "Attention!! Tout est à 99 Dhs sur une sélection d'articles, du Samedi 10 au Vendredi 16 juillet 2021. MORINO WOMEN SIDI ABAD et MASSIRA, à très vite.";
        
        // $customers = Customer::where('sexe','=',1)->where('store_id','=',1)->orderBy('points','DESC')->take(200)->get();
        
       
        // foreach($customers as $customer){
        //         $data = [];
        //         $data['camp_id']    = 6;
        //         $data['store_id']   = 1;//hard coded for now
        //         $data['phone']      = str_replace(' ','',$customer->phone);
        //         $data['message']    = $message;
        //         $data['start_date'] = Carbon::now();
        //         $data['sender']     = 'MORINO';
                
        //         $this->campaignService->singleCampaign($data);
        // }
        
        // return 1;
               
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($items=25)
    {
     
        switch (auth()->user()->is_admin) {
            case '1':
                return view('admin.customers.list', compact('clients', 'stores'));
                break;
            case '2':

                return view('owner.customers.list', compact('clients', 'stores'));
            break;
            case '3':
                
                 $store=Store::findOrFail(auth()->user()->store_id);
                 $owner=User::findOrFail($store->user_id);
                (isset( $_GET['items']) ) ? $items=$_GET['items'] : $items=25 ;
                if( isset($_GET['start_date']) ||  isset($_GET['end_date'])   )
                $customers=CustomerService::getSharedCustomerView($owner,$items,$_GET['start_date'],$_GET['end_date']);
                else
                $customers=CustomerService::getSharedCustomerView($owner,$items);
                return view('employe.customers.list', compact('customers'));
            break;
            
            default:
                return abort(403);
                break;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
  
        $validated = $request->validate([
            'phone' => 'required|regex:/(212)[0-9]{9}/',
            'sexe'  => 'required|not_in:-1'
        ]);

        $customer=Customer::create([
            'firstname'=>$request->firstname,
            'lastname'=>$request->lastname,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'birth'=> $request->birth,
            'sexe'=>$request->sexe,
            'store_id'=>auth()->user()->store_id,
            'user_id'=>auth()->user()->id,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        if($request->type==1){
            return   "<option selected value='".$customer->id."'>".$customer->getFullNameAttribute()." : " .$customer->phone. " </option>" ;
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getCustomerPoints(Request $request)
    {
        $customer=Customer::find($request->customer_id);
        $store=Store::find(auth()->user()->store_id);
        return ['mad_red' => $customer->points, 'points_red' => $customer->points * $store->coeff];
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer=Customer::find($id);
        return view('employe.customers.edit',compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $customer=Customer::findOrFail($id);
        $customer->firstname=$request->firstname;
        $customer->lastname=$request->lastname;
        $customer->sexe=$request->sexe;
        $customer->phone=$request->phone;
        $customer->email=$request->email;
        $customer->birth=$request->birth;
        $customer->save();
        return redirect()->route('employe.customers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
     public function getCustomerRed(Request $request)
    {

        $campaignHistory = CampaignHistorique::where('code_red','=',$request->code)->where('customer_id','=',$request->customer_id)->where('expired_code','=',0)->first();
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
}
