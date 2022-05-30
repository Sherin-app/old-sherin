<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Events\OwnerEvent;
use App\Http\Requests\OwnerRequest;
use App\Services\InvoiceService;
use App\Services\CustomerService;
use App\Services\SmsService;
use App\Models\EmailCampaign;
use App\User;
use Event;
use Illuminate\Support\Carbon;

class OwnerController extends Controller
{
   

    public function getDashboard(){
      
        $stores_id=[];
        foreach(auth()->user()->stores as $item)
                array_push($stores_id,$item->id);
        
        $invoices=InvoiceService::getOwnerInvoices($stores_id,0);
        $total_vente=InvoiceService::getTotalVenteOwner($stores_id);
        $customers=CustomerService::getlastCustomersOwner(auth()->user()->id);
       
        $ca=InvoiceService::getTurnOverOwner($stores_id);
        $ca_today=InvoiceService::getTurnOverOwnerToday($stores_id);
        $ca_last_day = InvoiceService::getTurnOverOwnerBeforeToday($stores_id);
        $ca_week=InvoiceService::getTurnOverOwnerWeek($stores_id);
        $ca_month=InvoiceService::getTurnOverOwnerMonth($stores_id);
        
        $retention=InvoiceService::getRetention($customers);
        
        $orderAverage=InvoiceService::getOrderAverage(InvoiceService::getOwnerInvoices($stores_id,1));
        $stores=(isset(auth()->user()->stores) ) ? auth()->user()->stores: []; 
        // //function to get the C.A of each store
        
        $emails=EmailCampaign::whereIn('store_id',$stores_id)->where('status','=',1)->get()->count();
        
        //get the Top 10 selller in all stores
        $sellers=InvoiceService::getBestSellers($stores)->map(function($el){
            $seller = [];
            $seller['total'] = $el->total;
            $seller['invoice_date'] = Carbon::parse($el->invoice_date)->format('Y-m')  ;
            $seller['firstname'] = $el->firstname;
            $seller['lastname'] = $el->lastname;
            $seller['user_id'] = $el->user_id;
            $seller['store_name'] = $el->name;
            return collect($seller);
        });
        $best_sellers =  $sellers->groupBy('invoice_date')->map(function($el){
            return $el->groupBy('user_id');
        })->take(2);
        $topsellers = [];
        foreach($best_sellers as $key=>$sellers){
                foreach($sellers as $seller){
                    $total = 0;
                    $object = [];
                    foreach($seller as $el){
                        $total = $total + $el['total'];
                    }
                    $object['firstname'] = $seller->first()['firstname'];
                    $object['lastname']  = $seller->first()['lastname'];
                    $object['store']     = $seller->first()['store_name'];
                    $object['period']    = $key;
                    $object['total']     = $total;
                    array_push($topsellers,$object);
                }
        }
        $sellers = collect($topsellers)->groupBy('period')->sortBy('total');
        $stores_camps = [];
        foreach($stores as $store){
            if($store->allow_camp==1)
                array_push($stores_camps,$store->id);
        }
        $countSms    = SmsService::countSms(auth()->user()->stores->pluck('id')->toArray());
        
        return view('dashboard.dashboard-02',compact('customers','emails','invoices','total_vente','ca','ca_today','ca_last_day','ca_week','ca_month','retention','orderAverage','stores','sellers','countSms'));
    }

    

    public function getChartData($type)
    {
        $stores_id=[];
        //the evolution of Turn Over for each month
        foreach(auth()->user()->stores as $item)
            array_push($stores_id,$item->id);
        $data=InvoiceService::getRedAccGranted($stores_id,$type);
        return $data;
    }
    
    public function getRepportData()
    {
        //['store name','month','numbre']
        $data=InvoiceService::getCustomersStoresByDate(auth()->user()->stores);
        return $data;
    }

    public function getTurnOver()
    {
        $customers=CustomerService::getlastCustomersOwner(auth()->user()->id);
        $data=InvoiceService::turnOverStores(auth()->user()->stores,$customers);
        return $data;

    }

    public function getSoldeDetail()
    {
        return view('owner.solde');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $owners = User::where('is_admin','=','2')->orderBy('id', 'DESC')->get();
        //dd($owners);
        return view('admin.owners.list', compact('owners'));
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
        //dd($request->all());
        $request->has('allow_share') ? $allow = 1 : $allow = 0;
        $owner = User::create([
            'firstname' => $request['firstname'],
            'lastname' => $request['lastname'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'phone' => $request['phone'],
            'allow_share' => $request['allow_share'],
            'is_admin' => 2,
            'allow_share'=>$allow,
        
        ]);
        // Event::dispatch(new OwnerEvent($owner,$request->password));
        return redirect()->route('admin.owners');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $owner=User::where('is_admin','=',2)->where('id','=',$id)->first();
        return  view('admin.owners.edit',compact('owner'));
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
        $owner=User::find($id);
        $newOwner['firstname']=$request['firstname'];
        $newOwner['lastname']=$request['lastname'];
        $newOwner['phone']=$request['phone'];
        if($request->has('password')){
            $newOwner['password']=Hash::make($request['password']);
        }
        if($request->has('allow_share')){
            $newOwner['allow_share']=1;
        }
        $owner->update($newOwner);
        // Event::dispatch(new OwnerEvent($owner,$request->password));
        return redirect()->route('admin.owners');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $owner=User::find($id);
        $owner->is_active=0;
        $owner->save();
        return redirect()->route('admin.owners');
    }

    public function active($id)
    {
        $owner=User::find($id);
        $owner->is_active=1;
        $owner->save();
       
        return redirect()->route('admin.owners');
    }

}
