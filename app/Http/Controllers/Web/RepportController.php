<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\CampaignHistorique;
use App\Models\EmailCampaign;
use DB;

class RepportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getInvoices(Request $request)
    {
        $invoices = [];
        $total = 0;
        if (isset($_GET['store_id']) || isset($_GET['start_date']) || isset($_GET['end_date'])) {
            $this->validate($request, [
                'store_id'  => 'required',
                'start_date' => 'required',
                'end_date'  => 'required',
            ], [
                'store_id.required'   => __('Le Champ Store est requis'),
                'start_date.required'   => __('Le Champ Date Debut est requis'),
                'end_date.required'   => __('Le Champ Date fin est requis'),
            ]);
            $invoices = Invoice::where('status', '=', 0)->where('store_id', '=', $request->store_id)->whereBetween('invoice_date', [$request->start_date, $request->end_date])->get();
            foreach ($invoices as $invoice) {
                $total = $total + $invoice->total;
            }
        }

        return view('owner.repport.invoices', [
            'stores' => auth()->user()->stores->pluck('name', 'id'),
            'invoices' => $invoices,
            'total'   => $total
        ]);
    }

    public function getCustomers(Request $request)
    {
        $customers = [];
        $total = 0;

        if (isset($_GET['store_id']) || isset($_GET['start_date']) || isset($_GET['end_date'])) {
            $this->validate($request, [
                'store_id'  => 'required',
                'start_date' => 'required',
                'end_date'  => 'required',
            ], [
                'store_id.required'   => __('Le Champ Store est requis'),
                'start_date.required'   => __('Le Champ Date Debut est requis'),
                'end_date.required'   => __('Le Champ Date fin est requis'),
            ]);
            $customers = Customer::where('store_id', '=', $request->store_id)->whereBetween('created_at', [$request->start_date, $request->end_date])->get();
            $total = $customers->count();
        }

        return view('owner.repport.customers', [
            'stores'     => auth()->user()->stores->pluck('name', 'id'),
            'customers'   => $customers,
            'total'      => $total
        ]);
    }

    public function getProducts(Request $request)
    {

        $products = [];
        $total = 0;
        $totalMargeBrute = $totalSell = 0;

        if (isset($_GET['store_id']) || isset($_GET['start_date']) || isset($_GET['end_date'])) {

            if (!in_array($_GET['store_id'], auth()->user()->stores->pluck('id')->toArray()))
                return abort(404);

            $this->validate($request, [
                'store_id'  => 'required',
                'start_date' => 'required',
                'end_date'  => 'required',
            ], [
                'store_id.required'   => __('Le Champ Store est requis'),
                'start_date.required'   => __('Le Champ Date Debut est requis'),
                'end_date.required'   => __('Le Champ Date fin est requis'),
            ]);

            $products = DB::table('invoices')
                ->join('invoice_products', 'invoice_products.invoice_id', '=', 'invoices.id')
                ->join('products', 'invoice_products.product_id', 'products.id')
                ->where('products.store_id', '=', $_GET['store_id'])
                ->whereBetween('invoice_date', [$request->start_date, $request->end_date])
                ->selectRaw('invoice_products.product_id ,  sum(total) AS r_total')
                ->select('invoice_products.*', 'products.*')
                ->groupBy('invoice_products.product_id')
                ->selectRaw('invoice_products.product_id ,  sum(qte) AS qte_total')
                ->get();
            foreach ($products as $product) {
                $totalSell = $totalSell + ($product->price * $product->qte_total);
                $totalMargeBrute = $totalMargeBrute + ($product->price - $product->promotion_price) * $product->qte_total;
            }
            $total = $products->count();
        }


        return view('owner.repport.products', [
            'stores'     => auth()->user()->stores->pluck('name', 'id'),
            'products'   => $products,
            'total'      => $total,
            'totalSell'      => $totalSell,
            'totalMargeBrute'      => $totalMargeBrute,
            
        ]);
    }

    public function getCampaigns(Request $request)
    {
        //get email campaigns and sms campaigns
        //get all the sms now 
        $data = [];


        if (!is_null($request->campaign) && $request->campaign == 0) {
            $type = 0;
            $data = CampaignHistorique::where('store_id', '=', $request->store_id)
                ->whereBetween('created_at', [$request->start_date, $request->end_date])->get();
        } else {
            $type = 1;
            $data = EmailCampaign::where('store_id', '=', $request->store_id)
                ->whereBetween('created_at', [$request->start_date, $request->end_date])->get();
        }


        return view('owner.repport.campaigns', [
            'stores'     => auth()->user()->stores->pluck('name', 'id'),
            'data'       => $data,
            'total'      => count($data),
            'type'       => $type
        ]);
    }
}
