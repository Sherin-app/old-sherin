<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Template;
use Carbon\Carbon;
use App\Services\CampaignService;

class CampaignController extends Controller
{
    
     protected $campaignService;
    public function __construct(CampaignService $campaignService)
    {
        $this->campaignService = $campaignService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $templates=Template::where('status','=',1)->get();
        $campaigns=Campaign::all();
        return view('admin.campaign.list',compact('campaigns','templates'));
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
    
    
    
    public function singleCampaign(Request $request)
    {
       
        
        $this->validate($request,[
                'phone'=>'required',
                'message'=>'required|string|max:160',
        ]);
                $data = [];
                $data['camp_id']  = 6;
                $data['store_id'] = auth()->user()->stores->first()->id;//hard coded for now
                $data['phone']    = str_replace(' ','',$request->phone);
                $data['message']  = $request->message;
                $data['start_date'] = Carbon::now();
                $data['sender']     =  auth()->user()->stores->first()->sender_id;
            
            $this->campaignService->singleCampaign($data);
            if(auth()->user()->is_admin==1)
                return redirect('dashboard/index');
        return redirect('dashboard/owner');
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            $this->validate($request,[
                'model'=>'required|not_in:0',
                'campaign_name'=>'required',
                'send_nature'=>'required|not_in:-1',
                'message'=>'required',
            ]);
            
            $campaign=Campaign::create([
            'template_id'=>$request->model,
            'campaign_name'=>$request->campaign_name,
            'nature_sending'=>$request->send_nature,
            'message'=>$request->message,
            'create_date'=>Carbon::now(),
        ]);

        return redirect()->to('/admin/campaigns');
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
     * get only the message of a campaign.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getCampaignMessage(Request $request)
    {
        $this->validate($request,[
            'campagn_id'=>'required|not_in:-1'
        ]);
        return Campaign::find($request->campagn_id)->message;
       
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
