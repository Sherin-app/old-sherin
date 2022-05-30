<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Fond;
use App\Models\InitialFond;
use Carbon\Carbon;
class CaisseController extends Controller
{
    
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $returnCard=0;
        $returnCheck=0;
        $returnCash=0;
        $encasementCard=0;
        $encasementCheck=0;
        $encasementCash=0;
        $disbursementCard=0;
        $disbursementCheck=0;
        $disbursementCash=0;
        
        isset($_GET['date']) && $_GET['date']!='' ? $date =  date('Y-m-d', strtotime( $_GET['date']))   : $date = Carbon::today();
        if(isset($_GET['store_id'])){
             $fonds = Fond::where('store_id',$_GET['store_id'])->whereDate('encasement_date',$date)->get();
            
        }else{
            $fonds = Fond::where('store_id',auth()->user()->store_id)->whereDate('encasement_date',$date)->get();
        }
        foreach($fonds as $fond)
        {
            if($fond->encasement_type==0){
                    if($fond->invoice->payment_method == 1){
                        //cash
                        $encasementCash = $encasementCash + $fond->invoice->total;
                    }elseif($fond->invoice->payment_method == 2){
                        //check
                        $encasementCheck = $encasementCheck + $fond->invoice->total;
                       
                    }elseif($fond->invoice->payment_method == 3){
                        //card
                         $encasementCard = $encasementCard + $fond->invoice->total;
                    }
               
            }elseif($fond->encasement_type==1){
                if($fond->invoice->payment_method == 1){
                    //cash
                    $disbursementCash = $disbursementCash + $fond->invoice->total;
                }elseif($fond->invoice->payment_method == 3){
                    //card
                    $disbursementCard = $disbursementCard + $fond->invoice->total;
                }elseif($fond->invoice->payment_method == 2){
                    //check
                    $disbursementCheck = $disbursementCheck + $fond->invoice->total;
                }
            }elseif($fond->encasement_type==2){
                if($fond->invoice->payment_method == 1){
                    //cash
                    $returnCash = $returnCash + $fond->value;
                }elseif($fond->invoice->payment_method == 3){
                    //card
                    $returnCard = $returnCard + $fond->value;
                }elseif($fond->invoice->payment_method == 2){
                    //check
                    $returnCheck = $returnCheck + $fond->value;
                }
            }
        }
        
        
        if(isset($_GET['store_id'])){
            $initialFond = InitialFond::where('store_id',$_GET['store_id'])->whereDate('date',$date)->first();
        }else{
             $initialFond = InitialFond::where('store_id',auth()->user()->store_id)->whereDate('date',$date)->first();
        }

       
        if(!$initialFond){
            $initialFond = 0;
        }else{
            $initialFond = $initialFond->value;
        }
        return view('owner.caisse.list',compact(
            'returnCard','returnCheck','returnCash','encasementCard' , 'encasementCheck' , 'encasementCash' , 'disbursementCard' , 'disbursementCheck' , 'disbursementCash' ,'initialFond' ));
        
    }

     /**
     * Display a listing of the resource
     */
    public function getCaisseEmployee()
    {
        $returnCard=0;
        $returnCheck=0;
        $returnCash=0;
        $encasementCard=0;
        $encasementCheck=0;
        $encasementCash=0;
        $disbursementCard=0;
        $disbursementCheck=0;
        $disbursementCash=0;
        
        
        isset($_GET['date']) && $_GET['date']!='' ? $date =  date('Y-m-d', strtotime( $_GET['date']))   : $date = Carbon::today();
        
        if(auth()->user()->is_admin==2){
             isset($_GET['store_id']) ? $store_id = $_GET['store_id'] : $store_id = auth()->user()->stores->first()->id;
                 $initialFond = InitialFond::where('store_id',$store_id)->whereDate('date',$date)->first();
            
        }else{
            $store_id = auth()->user()->store_id;
            $initialFond = InitialFond::where('store_id',auth()->user()->store_id)->whereDate('date',$date)->first();
        }
        
       
        
        
        $fonds = Fond::where('store_id',$store_id)->whereDate('encasement_date',$date)->get();
        foreach($fonds as $fond)
        {
            if($fond->encasement_type==0){
                    if($fond->invoice->payment_method == 1){
                        //cash
                        $encasementCash = $encasementCash + $fond->invoice->total;
                    }elseif($fond->invoice->payment_method == 2){
                        //check
                        $encasementCheck = $encasementCheck + $fond->invoice->total;
                       
                    }elseif($fond->invoice->payment_method == 3){
                        //card
                         $encasementCard = $encasementCard + $fond->invoice->total;
                    }
               
            }elseif($fond->encasement_type==1){
                if($fond->invoice->payment_method == 1){
                    //cash
                    $disbursementCash = $disbursementCash + $fond->invoice->total;
                }elseif($fond->invoice->payment_method == 3){
                    //card
                    $disbursementCard = $disbursementCard + $fond->invoice->total;
                }elseif($fond->invoice->payment_method == 2){
                    //check
                    $disbursementCheck = $disbursementCheck + $fond->invoice->total;
                }
            }elseif($fond->encasement_type==2){
                if($fond->invoice->payment_method == 1){
                    //cash
                    $returnCash = $returnCash + $fond->value;
                }elseif($fond->invoice->payment_method == 3){
                    //card
                    $returnCard = $returnCard + $fond->value;
                }elseif($fond->invoice->payment_method == 2){
                    //check
                    $returnCheck = $returnCheck + $fond->value;
                }
            }
        }
    
        if(!$initialFond){
            $initialFond = 0;
        }else{
            $initialFond = $initialFond->value;
        }

        // $caisse = InitialFond::where('store_id','=',auth()->user()->store->id)->laste();
      
        return view('employe.caisse.index',compact(
            'returnCard','returnCheck','returnCash','encasementCard' , 'encasementCheck' , 'encasementCash' , 'disbursementCard' , 'disbursementCheck' , 'disbursementCash' ,'initialFond' ));

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
        //
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
        //
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
        //
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
}
