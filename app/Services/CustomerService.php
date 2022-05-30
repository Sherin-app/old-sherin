<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Store;
use App\User;
use DB;

class CustomerService
{



    public static function getlastCustomersOwner($owner_id)
    {
        $stores = Store::where('user_id', '=', $owner_id)->get();
        $stores_id = [];
        foreach ($stores as $str)
            array_push($stores_id, $str->id);
        $customers = Customer::whereIn('store_id', $stores_id)->get();
        return $customers;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function getSharedCustomer($owner)
    {

        switch ($owner->allow_share) {
            case '0':
                $customers = Customer::where('store_id', '=', Auth()->user()->store_id)->orderBy('id', 'DESC')->get();

                return $customers;

                break;
            case '1':

                $stores = Store::where('user_id', '=', $owner->id)->get();
                $stores_id = [];
                foreach ($stores as $str)
                    array_push($stores_id, $str->id);
                $customers = Customer::whereIn('store_id', $stores_id)->orderBy('id', 'DESC')->get();
                return $customers;
                break;

            default:
                # code...
                break;
        }
    }

    public static function getSharedCustomerView($owner, $items,$start_date=null,$end_date=null)
    {
       
        switch ($owner->allow_share) {
            case '0':
                    if($start_date || $end_date){
                        $customers = Customer::where('store_id', '=', Auth()->user()->store_id)
                        ->whereBetween('created_at',[ $start_date, $end_date])
                        ->orderBy('id', 'DESC')->get();
                    }else{
                        $customers = Customer::where('store_id', '=', Auth()->user()->store_id)->orderBy('id', 'DESC')->take(100)->get();
                    }
                
                return $customers;
                break;
            case '1':

                $stores = Store::where('user_id', '=', $owner->id)->get();
                $stores_id = [];
                foreach ($stores as $str)
                    array_push($stores_id, $str->id);
                 if($start_date || $end_date){
                     $customers = Customer::whereIn('store_id', $stores_id)
                      ->whereBetween('created_at',[ $start_date, $end_date])
                     ->orderBy('id', 'DESC')->get();
                 }else{
                     $customers = Customer::whereIn('store_id', $stores_id)->orderBy('id', 'DESC')->take(100)->get();     
                 }
                
                return $customers;
                break;

            default:
                # code...
                break;
        }
    }

    public static function getlastCustomers($onwer_id)
    {
        $owner = User::find($onwer_id);

        switch ($owner->allow_share) {
            case '0':
                
                $customers = DB::table('customers')
                    ->leftJoin('customers_stores', 'customers_stores.customer_id', 'customers.id')
                    ->where('customers.store_id', Auth()->user()->store_id)
                    ->select('customers.*')
                    ->orderBy('id','DESC')
                    ->limit(10)->get();
                return $customers;

                break;
            case '1':
                
                $stores = Store::where('user_id', '=', $owner->id)->get();
                $stores_id = [];
                foreach ($stores as $str)
                    array_push($stores_id, $str->id);
                $customers = Customer::whereIn('store_id', $stores_id)->orderBy('id','DESC')->limit(10)->get();
                return $customers;
                break;

            default:
                # code...
                break;
        }
    }

    public function getCommunCustomersStore(){
        
    }

    public function getCustomerById(int $id){
        return Customer::find($id);
    }
}
