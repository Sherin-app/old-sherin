<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Store;
use App\User;

class StoreController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $activities = Activity::all();
        if (auth()->user()->is_admin == 1) {
            
            $owners = User::where('is_admin', '=', 2)->where('is_active', '=', 1)->get();
            $stores = Store::OrderBy('id','DESC')->get();
            return view('admin.stores.list', compact('stores', 'owners', 'activities'));
        } else {
           
            $stores = Store::where('user_id', '=', auth()->user()->id)->orderBy('id','DESC')->get();
           
            return view('owner.stores.list', compact('stores', 'activities'));
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
        if(auth()->user()->is_admin==2) 
                return abort(403);
        if ($request->hasFile('logo')) {
            $store = Store::create([
                'user_id' => $request->owner_id,
                'activity_id' => $request->activity_id,
                'name' => $request->store_name,
                'sender_id' => $request->sender_id,
                'address' => $request->address,
                'contact' => $request->contact,
                'phone' => $request->phone,
                'base' => $request->base_calcul,
                'base_profit' => $request->base_profit,
                'coeff' => $request->coeff,
                'min_point_to_use' => $request->min_point_to_use,
                'logo' => $request->logo->getClientOriginalName(),
                'tva' => $request->tva,
                'invoice_message'=>$request->message_invoice
            ]);
            $this->move_files($request->logo, $store->id);
        } else {
            $store = Store::create([
                'user_id' => $request->owner_id,
                'activity_id' => $request->activity_id,
                'name' => $request->store_name,
                'sender_id' => $request->sender_id,
                'contact' => $request->contact,
                'phone' => $request->phone,
                'address' => $request->address,
                'base' => $request->base_calcul,
                'base_profit' => $request->base_profit,
                'coeff' => $request->coeff,
                'tva' => $request->tva
            ]);
        }
        return redirect()->route('admin.stores');
    }

    /* 
    * Function Move the File uploaded to new directory
    */
    protected function move_files($file, $id)
    {

        $destinationPath = 'uploads/stores/' . $id . '/';
        //move each file to destination path
        $file->move($destinationPath, $file->getClientOriginalName());
        $file_names = $file->getClientOriginalName();
        return $file_names;
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
        if (auth()->user()->is_admin == 1) {
            $owners = User::where('is_admin', '=', 2)->where('is_active', '=', 1)->get();
            $activities = Activity::all();
            $store = Store::find($id);
            return view('admin.stores.edit', compact('store', 'activities', 'owners'));
        } else {
            $activities = Activity::all();
            $store = Store::find($id);
            if (auth()->user()->id != $store->user_id)
                return abort(404);
            return view('owner.stores.edit', compact('store', 'activities'));
        }
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
        if (auth()->user()->is_admin == 1) {
            $owner_id = $request->owner_id;
        } elseif (auth()->user()->is_admin == 2) {
            $owner_id = auth()->user()->id;
        }

        if ($request->hasFile('logo')) {
            $result = Store::where('id', $id)->update([
                'user_id' => $owner_id,
                'activity_id' => $request->activity_id,
                'name' => $request->store_name,
                'sender_id' => $request->sender_id,
                'address' => $request->address,
                'contact' => $request->contact,
                'phone' => $request->phone,
                'base' => $request->base_calcul,
                'base_profit' => $request->base_profit,
                'coeff' => $request->coeff,
                'logo' => $this->move_files($request->logo, $id),
                'tva' => $request->tva,
                'invoice_message'=>$request->message_invoice

            ]); //remove the image exesting in stores directory next
            // uploadFile($request->logo,$request->owner,'stores');
        } else {

            $result = Store::where('id', $id)->update([
                'user_id' => $owner_id,
                'activity_id' => $request->activity_id,
                'name' => $request->store_name,
                'sender_id' => $request->sender_id,
                'contact' => $request->contact,
                'phone' => $request->phone,
                'address' => $request->address,
                'base' => $request->base_calcul,
                'base_profit' => $request->base_profit,
                'coeff' => $request->coeff,
                'tva' => $request->tva,
                'invoice_message'=>$request->message_invoice
            ]);
        }
        if (auth()->user()->is_admin == 1)
            return redirect()->route('admin.stores');
        return redirect()->route('owner.stores');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $store = Store::findOrFail($id);
        $store->status = 0;
        $store->save();
        return redirect()->route('admin.stores');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function activate($id)
    {
        $store = Store::findOrFail($id);
        $store->status = 1;
        $store->save();
        if (auth()->user()->is_admin == 1) {
            return redirect()->route('admin.stores');
        } elseif (auth()->user()->is_admin == 2) {
            return redirect()->route('owner.stores');
        }
    }
}
