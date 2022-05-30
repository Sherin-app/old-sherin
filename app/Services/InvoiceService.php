<?php

namespace  App\Services;

use Maatwebsite\Excel\Facades\Excel;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoicePaiement;
use App\Models\InvoiceProduct;
use App\Models\Store;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use DB;
use PDF;
use Config;
use App\Helpers\CollectionHelper;
class InvoiceService
{

    /**
     * @calculate the new points if we used the balance points
     */
    public static function calculatePoints($is_positive, $client, $total, $base_profit, $base)
    {

        if ($is_positive) {
            $reduction_mad = $total * ($base_profit / $base);
            $x = ($total * $base_profit) / 100;
        } else {
            $x = ($total - $client->points) * (-1);
        }
        return $x;
    }
    /**
     * @calculate the new points if we  don't use  balance points
     */

    public static function calculatePointsWithoutBalance($total, $client, $coeff, $base_profit, $base)
    {

        $reduction_mad = $total* ($base_profit / $base);
        $reduction_point = $reduction_mad * $coeff;
        $use_red = $client->points + (int)$reduction_mad;
        $client->points = $use_red;
        $client->save();
        return $use_red;
    }


    public function updatePoints($total,$customer){
        if (($total  - $customer->points) >= 0) {
            $use_red = $this->calculatePoints(true, $customer, $total, $customer->store->base_profit, $customer->store->base);
        } else {
            $use_red = $this->calculatePoints(false, $customer, $total, $customer->store->base_profit,$customer->store->base);
        }
        return $use_red;
    }

    public function updatePointsWithoutBalance($total,$customer){
        return $this->calculatePointsWithoutBalance($total, $customer, $customer->storecoeff, $$customer->store->base_profit,$customer->store->base);
    }

    public static function createInvoice($store_id, $user_id, $use_red, $data)
    {
        $invoice = new Invoice();
        $invoice->store_id = $store_id;
        $invoice->user_id = $user_id;
       $invoice->employ_id = in_array(auth()->user()->store_id,[19]) ? $user_id : auth()->user()->id;
        $invoice->customer_id = $data['customer'];
        $invoice->paid_amount = $data['montant_paye'] > 0 ?  $data['montant_paye'] : 0 ;
        $invoice->for_sexe    =  isset($data['for']) ? $data['for'] : 3 ;
        $invoice->invoice_date = date('Y-m-d H:i:s');
        $invoice->points = $use_red;
        $invoice->description = isset($data['description']) ? $data['description']  : '';
        $invoice->payment_method = isset($data['payment_method']) ? $data['payment_method'] : 1;
        $invoice->total = $data['total'] > 0 ?  $data['total'] : 0 ;// i added  *0.9 for reduction
        $invoice->total_ht = $data['total_ht'] > 0 ?  $data['total_ht'] : 0 ;// i added  *0.9 for reduction
        $invoice->status = 0;
        $invoice->save();
        return $invoice->id;
    }

    public static function createInvoicePaiement($id, $data)
    {
        $invoicePaiement = new InvoicePaiement();
        $invoicePaiement->invoice_id = $id;
        $invoicePaiement->amount = $data['montant_paye']  > 0 ?  $data['montant_paye'] : 0  ;
        $invoicePaiement->date = date('Y-m-d H:i:s');
        $invoicePaiement->save();
    }

    public static function createInvoiceProduct($id, $data, $total)
    {

        foreach ($data['products'] as $key => $val) {
            if ($val != 0) {
                $inv_prod = new InvoiceProduct();
                $inv_prod->invoice_id = $id;
                $inv_prod->product_id = $val;
                $inv_prod->qte = isset($data['quantity'][$key]) ? $data['quantity'][$key] : 1;
                $inv_prod->price = Product::find($val)->price;
                $inv_prod->save();
            }
        }
    }

    public static function cancelInvoice($id)
    {
        $invoice = Invoice::find($id);
        $invoice->status = 2;
        $invoice->save();
    }

    public static function printInvoice($id)
    {
        
        $factures = DB::table('invoices')
            ->leftJoin('invoice_products', 'invoice_products.invoice_id', 'invoices.id')
            ->leftJoin('products', 'invoice_products.product_id', 'products.id')
            ->leftJoin('customers', 'invoices.customer_id', 'customers.id')
            ->leftJoin('stores', 'invoices.store_id', 'stores.id')
            ->select('invoices.*', 'invoice_products.qte', 'invoice_products.price', 'invoice_products.product_id', 'customers.firstname', 'customers.lastname','customers.points as myPoints', 'customers.phone', 'products.label', 'stores.id as store_id', 'stores.logo as store_logo', 'stores.name as store_name', 'stores.address as store_address', 'stores.phone as store_phone')
            ->where('invoices.id', $id)
            ->get();
        return $factures;
    }
    public static function getTotalVente()
    {
        $products = DB::table('invoices')
            ->where('invoices.user_id', '=', auth()->user()->id)
            ->join('invoice_products', 'invoices.id', 'invoice_products.invoice_id')
            ->whereDate('invoices.invoice_date', Carbon::today())
            ->get();
        $count = 0;
        foreach ($products as $item) {
            $count = $count + $item->qte;
        }
        return $count;
    }

    public static function getTotalVenteOwner($stores_id)
    {
        $products = DB::table('invoices')
            ->join('invoice_products', 'invoices.id', 'invoice_products.invoice_id')
            ->whereIn('invoices.store_id', $stores_id)
            ->where('invoices.status','=',0)
            ->whereDate('invoices.invoice_date', Carbon::today())
            ->get();
            
        $count = 0;
        foreach ($products as $item) {
            if($item->status==0)
            $count = $count + $item->qte;
        }
        return $count;
    }

    public static function getTotalCustomer()
    {
        $visites = Invoice::whereDate('invoice_date', Carbon::today())->count();
        return $visites;
    }

    public static function getRealisedObjectives()
    {
        $data = [];
        $today = 0;
        $this_week = 0;
        $this_month = 0;
        $today_invoices = Invoice::whereDate('invoice_date', Carbon::today())->where('user_id', '=', auth()->user()->id)->where('status', '=', 0)->get();
        foreach ($today_invoices as $item_today) {
            $today = $today + $item_today->total;
        }
        $data['today'] = $today;
        $this_week_invoices = Invoice::where('user_id', '=', auth()->user()->id)->where('status', '=', 0)->whereBetween('invoice_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
        foreach ($this_week_invoices as $item) {
            $this_week = $this_week + $item->total;
        }
        $data['this_week'] = $this_week;

        $this_month_invoices = Invoice::where('user_id', '=', auth()->user()->id)->where('status', '=', 0)->whereBetween('invoice_date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->get();
        foreach ($this_month_invoices as $item) {
            $this_month = $this_month + $item->total;
        }
        $data['this_month'] = $this_month;
        return $data;
    }

    public static function getTurnOver()
    {
        $invoices = Invoice::where('user_id', '=', auth()->user()->id)->where('status', '=', 0)->get();
        $ca = 0;
        foreach ($invoices as $item)
            $ca = $ca + $item->total;
        return $ca;
    }

    public static function getTurnOverOwner($stores_id)
    {
        $invoices = Invoice::whereIn('store_id', $stores_id)->where('status', '=', 0)->get();
        $ca = 0;
        foreach ($invoices as $item)
            $ca = $ca + $item->total;
        return $ca;
    }

    public static function getTurnOverOwnerToday($stores_id)
    {
        $invoices = Invoice::whereIn('store_id', $stores_id)->where('status', '=', '0')->whereDate('invoice_date', Carbon::today())->get();
        $ca = 0;
        foreach ($invoices as $item)
            $ca = $ca + $item->total;
        return $ca;
    }
    public static function getTurnOverOwnerBeforeToday($stores_id)
    {
        $invoices = Invoice::whereIn('store_id', $stores_id)->where('status', '=', '0')->whereDate('invoice_date',  Carbon::now()->subDays(1) )->get();
        $ca = 0;
        foreach ($invoices as $item)
            $ca = $ca + $item->total;
        return $ca;
    }
    public static function getTurnOverOwnerWeek($stores_id)
    {
        $invoices = Invoice::whereIn('store_id', $stores_id)->where('status', '=', 0)->whereBetween('invoice_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
        $ca = 0;
        foreach ($invoices as $item)
            $ca = $ca + $item->total;
        return $ca;
    }

    public static function getTurnOverOwnerMonth($stores_id)
    {
        $invoices = Invoice::whereIn('store_id', $stores_id)->where('status', '=', 0)->whereBetween('invoice_date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->get();
        $ca = 0;
        foreach ($invoices as $item)
            $ca = $ca + $item->total;
        return $ca;
    }

    public static function getRetention($customers)
    {
        $retentionRate = 0;

        if ($customers) {
            foreach ($customers as $cl) {
                $clInv = Customer::whereYear('created_at','=',date('Y'))->whereMonth('created_at','=',date('m'))->get();
                
                if (count($clInv) > 1) {
                    $retentionRate++;
                }
            }
        } else {
            $retentionRate = 0;
        }
        return $retentionRate;
    }

    public static function getOrderAverage($invoices)
    {
        $count = $result = 0;
        foreach ($invoices as $item) {
            if ($item->status == 0) {
                $result = $result + $item->total;
                $count++;
            }
        }
        return ($count == 0) ? $result / 1 : $result / $count;
    }


    public static function getAuthInvoices()
    {
        $invoices = Invoice::where('user_id', '=', auth()->user()->id)->orderBy('id', 'desc')->limit(10)->get();
        return $invoices;
    }

    public static function getOwnerInvoices($stores_ids,$type)
    {
        if($type==0){
             return $invoices = Invoice::whereIn('store_id', $stores_ids)->limit(3)->get();
        }else{
             return $invoices = Invoice::whereIn('store_id', $stores_ids)->whereDate('invoice_date', Carbon::today())->get();
        }
       
    }

    public static function getBestSellers($stores)
    {
        $stores_id = [];
        $employers_id = [];
        $total_ca = [];
        $ca = 0;
        foreach ($stores as $item)
            array_push($stores_id, $item->id);
        $employers = User::whereIn('store_id', auth()->user()->stores->pluck('id')->toArray())->get();
        
        foreach ($employers as $item)
            array_push($employers_id, $item->id);
        $top_sellers =  DB::table('invoices')
            ->join('users', 'users.id', '=', 'invoices.user_id')
            ->join('stores', 'users.store_id', '=', 'stores.id')
            ->where('invoices.status', '=', 0)
            ->whereIn('users.store_id',auth()->user()->stores->pluck('id')->toArray())
            ->whereDate('invoice_date', '>', Carbon::now()->subDays(90))
            ->get();
        return $top_sellers;
    }

    public static function getTurnOverEvolution($stores)
    {
        $data = [];
        $stores_invoices = [];

        foreach ($stores as $item) {
            $ca = 0;
            $data['store'] = Store::find($item->id)->name;
            $invoices = Invoice::where('store_id', '=', $item->id)->where('status', '=', 0)->get()->groupBy(

                function ($date) {
                    return Carbon::parse($date->invoice_date)->format('Y-m'); // grouping by years
                }
            );
            foreach ($invoices as $key => $values) {
                $data['date'][] = $key;

                $total = 0;
                foreach ($values as $inv) {
                    $data['date']['total'] = $total + $inv->total;
                }
            }
        }

        //chiffre d'affaire realiser dans une date pour chaque pour un magasin X
        /**
         * series :[
         *   'store'=>'XBELL',
         *    'ca' =>[230,450,340], 
         *    'date'=>'23-01-2021'  
         * ]
         */


        return collect($data);
    }

    public static function turnOverStores($stores,$customers)
    {
        $data = [];
        $series = [];
        $labels=[];

        $retentionRate = 0;

        if ($customers) {
            foreach ($customers as $cl) {
                $clInv = Invoice::where('customer_id', '=', $cl->id)->get();
                if (count($clInv) > 1) {
                    $retentionRate++;
                }
            }
        } else {
            $retentionRate = 0;
        }

        foreach ($stores as $item) {
            $invoices = Invoice::where('store_id', '=', $item->id)->where('status', '=', 0)->get()->groupBy(function ($date) {
                return Carbon::parse($date->invoice_date)->format('Y-m'); // grouping by years
            });
            foreach($invoices as $key=>$items){
                $total=0;
                foreach($items as $item){
                    $total=$total+$item->total;
                }
                $data['labels'][]=$key;
                $data['series'][]=$total;
            }
        }
        
        return ['labels'=>$data['labels'],'series'=>$data['series'],'retention'=>$retentionRate];
       /*data[
        *  'labels'=>store name ,
            'series'=>[
                [0,1,2...],
                [0,1,2...],
                [0,1,2...],
            ]
       *]
        **/
    }

    public static function countEmails($stores_ids)
    {
        $invoices = $invoices = Invoice::whereIn('store_id', $stores_ids)->get();
        $count = 0;
        foreach ($invoices as $item) {
            $customer = Customer::find($item->customer_id);
            if (isset($customer->email)) {
                $count++;
            }
        }
        return $count;
    }

    public static function getRedAccGranted($stores_id, $type)
    {
        $data = [];
        $list = [];
        $invoices = Invoice::whereIn('store_id', $stores_id)->where('status', '=', 0)->get()->groupBy(
            function ($date) {
                return Carbon::parse($date->invoice_date)->format('Y-m'); // grouping by years
            }
        );
        foreach ($invoices as $key => $items) {
            $total = 0;
            if ($type == 0)
                foreach ($items as $item) {
                    if ($type == 0) {
                        $total = $total + $item->total;
                    } elseif ($type == 1) {
                        $total = $total + $item->points;
                    }
                }
            $data['categories'] = $key;
            $data['total'] = $total;
            array_push($list, $data);
        }
        return collect($list);
    }

    public static function getInvoices($request)
    {
            
        $query =Invoice::query()->join('customers','customers.id','=','invoices.customer_id');
        
        if (isset($request->sexe)) {
           $query = $query->where('sexe', '=', $request->sexe);
        }
        if (isset($request->birth)) {
           $query = $query->where('birth', '=', $request->birth);
        }
        if (isset($request->reduction)) {
            if (isset($request->operator))
               $query = $query->where('invoices.points', getOperator(Config::get('constant.operators'),$request->operator), $request->reduction);
        }
        if (isset($request->start_date) && isset($request->end_date) ) {
             $query = $query->whereBetween('invoice_date',[$request->start_date,$request->end_date]);
        }
       
      
        $result=$query->get();
        return $result;
        return count( CollectionHelper::paginate($result,25) ) > 0  ?  CollectionHelper::paginate($result,25) : []  ;
    }


    public static function getCustomersStoresByDate($stores)
    {

        $data = [];
        $result = [];
        foreach ($stores as $item) {
            $invoices = Invoice::where('store_id', '=', $item->id)->where('status', '=', 0)->get()->groupBy(function ($date) {
                return Carbon::parse($date->invoice_date)->format('Y-m'); // grouping by years
            });
            //['store name','date','count']
            foreach ($invoices as $key => $items) {
                $data[$item->id]['x'] = $key;
                $data[$item->id]['y'] = count($items);
                $data[$item->id]['z'] = $item->id;
            }
        }
        foreach ($data as $key => $el)
            array_push($result, $el);
        return $result;
    }
}
