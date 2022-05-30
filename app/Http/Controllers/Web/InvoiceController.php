<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ProductService;
use App\Services\CampaignService;
use App\Services\CustomerService;
use App\Services\InvoiceService;
use App\Events\OrderEvent;
use App\Models\Store;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\CampaignHistorique;
use App\Models\Fond;
use App\User;
use Carbon\Carbon;
use DB;
use Config;
use PDF;
use Mail;
use Event;

class InvoiceController extends Controller
{

    protected $campaignService;

    public function __construct()
    {
        $this->campaignService = new CampaignService();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if (isset($_GET['start_date']) || isset($_GET['end_date'])) {

            $this->validate($request, [

                'start_date' => 'required',
                'end_date'  => 'required',
            ], [

                'start_date.required'   => __('Le Champ Date Debut est requis'),
                'end_date.required'   => __('Le Champ Date fin est requis'),
            ]);
            $invoices = Invoice::where('store_id', '=', auth()->user()->store->id)->whereBetween('invoice_date', [$request->start_date, $request->end_date])->OrderBy('id', 'DESC')->get();
        } else {
            $invoices = Invoice::where('store_id', '=', auth()->user()->store->id)
                ->whereBetween('invoice_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->OrderBy('id', 'DESC')->get();
        }



        return view('employe.invoices.list', compact('invoices'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getOwnerInvoices(Request $request, $items = 25)
    {

        $stores_id = [];
        foreach (Store::where('user_id', '=', auth()->user()->id)->get() as $store) {

            array_push($stores_id, $store->id);
        }

        $invoices = Invoice::whereIn('store_id', $stores_id)->OrderBy('id', 'DESC')->get();


        return view('owner.invoices.invoices', compact('invoices'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //get the clients 
        $store = Store::find(auth()->user()->store_id);
        //get the owner and check if sharing data is allowed 
        $owner = User::where('id', '=', $store->user_id)->first();
        $customers = CustomerService::getSharedCustomer($owner);
        $products = ProductService::index();
        $employes = User::where('store_id', '=', $store->id)->get();
        return view('employe.invoices.create', compact('customers', 'products', 'employes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate for sexe_type
        
        $validatedData = $request->validate([
            'montant_paye' => ['required'],
            'products'      => ['required', 'not_in:0'],
            'customer' => ['required', 'not_in:0'],
        ]);

        $data = $request->all();

        $client = Customer::find($request->customer);
        $use_red_final = $client->points;
        $store = Store::find(auth()->user()->store_id);
        $base = $store->base;
        $base_profit = $store->base_profit;
        $total = ceil($request->total); // i added  *0.9 for reduction
        $to_paye = ceil($request->montant_paye); // i added  *0.9 for reduction

        if ($request->use_points == 1) {

            if (($request->total - $client->points) >= 0) {

                $use_red = InvoiceService::calculatePoints(true, $client, $total, $base_profit, $base);
            } else {

                $use_red = InvoiceService::calculatePoints(false, $client, $total, $base_profit, $base);
            }
        } else {

            $points_without_discount = InvoiceService::calculatePointsWithoutBalance($total, $client, $store->coeff, $base_profit, $base);
            $use_red_final = $use_red = 0;
        }
        $userId = in_array(auth()->user()->store_id,[19,20]) && $request->userId!=0  ? $request->userId : Auth()->user()->id;
        $invoice_id = InvoiceService::createInvoice(Auth()->user()->store_id, $userId, $use_red, $data);
        InvoiceService::createInvoicePaiement($invoice_id, $data);
        InvoiceService::createInvoiceProduct($invoice_id, $data, 0);
        $tva = $store->tva;
        $invoice = Invoice::find($invoice_id);
        $invoice->total_ht = $request->total_ht; // i added  *0.9 for reduction
        $invoice->tva = auth()->user()->store->tva;
        if ($request->use_points == 1) {
            $invoice->points = $use_red_final;
            $client->points = 0;
        } else {
            $client->points = (int)($use_red_final + $points_without_discount);
        }

        $client->save();
        $invoice->save();

        if (isset($client->email)) {
            //   event(new OrderEvent($client, $invoice, $store));
        }
        Fond::create([
            'store_id'        => $store->id,
            'invoice_id'      => $invoice->id,
            'encasement_type' => 0,
            'encasement_date' => Carbon::now()
        ]);

        if ($request->code_valide == 1) {
            CampaignHistorique::where('customer_id', '=', $request->customer)->where('code_red', '=', $request->code_red)->first()->update(['expired_code' => 1, 'invoice_id' => $invoice->id]);
        }
        if (in_array(Auth()->user()->store_id ,[10,29])) {
            $path = 'messages.'.Auth()->user()->store->sender_id.'.welcome';
            $message =Config::get($path);
            $message = str_replace('(prénom)', $client->lastname, $message);
            $data = [];
            $data['camp_id']  = 6;
            $data['store_id'] = Auth()->user()->store_id; //hard coded for now
            $data['phone']    = $client->phone;
            $data['message']  =  $message;
            $data['start_date'] = Carbon::now();
            $data['sender']     =  Auth()->user()->store->sender_id;
            $this->campaignService->singleCampaign($data);
        }
        // $this->print($invoice->id);
        return redirect('employe/invoices');
    }


    public function renderProductRow()
    {

        $products = ProductService::index();
        $returnHTML = view('employe.invoices.row', compact('products'))->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }


    public function print($id)
    {

        $invoice = InvoiceService::printInvoice($id);

        // $customPaper = array(0, 0, 567.00, 283.80);
        $customPaper = array(0, 0, 650.00, 283.80);

        $pdf =  PDF::loadView('emails.invoice_new', array('content' => $invoice))->setPaper($customPaper, 'landscape');

        return $pdf->download("Facture_#" . $id . ".pdf");
    }

    public function returnInvoice(Request $request)
    {

        $invoice = Invoice::find($request->invoice_id);
        $store = Store::find(auth()->user()->store_id);
        $client = $invoice->customer;
        $base = $store->base;
        $base_profit = $store->base_profit;
        if ($invoice->points > 0) {
            $oldPoints =  InvoiceService::calculatePoints(false, $client, $request->hidden_total, $base_profit, $base);
        } else {
            $oldPoints =  InvoiceService::calculatePoints(true, $client, $request->hidden_total, $base_profit, $base);
        }
        if ($client->points - $oldPoints <= 0) {
            $client->points = 0;
            $client->save();
        } else {
            $client->points = (int) ($client->points - $oldPoints);
            $client->save();
        }
        $found   = Fond::create([
            'store_id'       => auth()->user()->store->id,
            'invoice_id'     => $request->invoice_id,
            'encasement_type' => 2,
            'value'          => $request->hidden_total,
            'encasement_date' => Carbon::now()
        ]);
        $found->refresh();
        return redirect('employe/invoices');
    }

    public function getReturns()
    {

        $founds = [];
        $total = 0;
        if (isset($_GET['store_id'])) {

            if (!in_array($_GET['store_id'], auth()->user()->stores->pluck('id')->toArray()))
                return abort(404);
            $founds = Fond::OrderBy('id', 'desc')->where('encasement_type', '=', 2)
                ->whereBetween('encasement_date', [$_GET['start_date'], $_GET['end_date']])
                ->where('store_id', '=', $_GET['store_id'])->get();
        }

        return view('owner.returns.index', compact('founds', 'total'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $store = Store::find(auth()->user()->store_id);
        //get the owner and check if sharing data is allowed 
        $owner = User::where('id', '=', $store->user_id)->first();
        $invoice = Invoice::find($id);
        $customer = Customer::find($invoice->customer_id);
        $products = InvoiceProduct::where('invoice_id', '=', $id)->get();
        return view('employe.invoices.detail', compact('customer', 'products', 'invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //get the clients 
        $store = Store::find(auth()->user()->store_id);
        //get the owner and check if sharing data is allowed 
        $owner = User::where('id', '=', $store->user_id)->first();
        $customers = CustomerService::getSharedCustomer($owner);
        $products = ProductService::index();
        $invoice = Invoice::find($id);
        if ($invoice->status == 0) {
            $customer = Customer::find($invoice->customer_id);
            //get the products of the invoice 
            $invoiceProducts = InvoiceProduct::where('invoice_id', '=', $id)->get();
            $employes = User::where('store_id', '=', $store->id)->get();
            return view('employe.invoices.edit', compact('customers', 'customer', 'products', 'invoice', 'employes', 'invoiceProducts'));
        } else {
            return abort(403);
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
        $validatedData = $request->validate([
            'montant_paye' => ['required'],
            'customer' => ['required', 'not_in:0'],
            // 'for'      => ['required']
        ]);
        $total_ht = $request->total_ht;

        $data = $request->all();
        $client = Customer::find($request->customer);
        $use_red_final = $client->points;
        $store = Store::find(auth()->user()->store_id);
        $base = $store->base;
        $base_profit = $store->base_profit;
        $total = ceil($request->total); // i added  *0.9 for reduction
        $to_paye = ceil($request->montant_paye); // i added  *0.9 for reduction
        $oldInvoice = Invoice::find($id);
        $old_points = InvoiceService::calculatePoints(true, $client, $oldInvoice->total, $oldInvoice->paid_amount, $base_profit, $base); // i added  *0.9 for reduction
        if ($client->points - $old_points <= 0) {
            $client->points = 0;
            $client->save();
        } else {
            $client->points = $client->points - $old_points;
            $client->save();
        }

        if ($request->use_points == 1) {

            if ($client->points > 0) {
                //before making anything plz update the points of the client 
                $old_points = InvoiceService::calculatePoints(true, $client, $total, $to_paye, $base_profit, $base);

                //end recalculate points
                if (($request->total - $client->points) >= 0) {

                    $use_red = InvoiceService::calculatePoints(true, $client, $total, $to_paye, $base_profit, $base);
                } else {

                    $use_red = InvoiceService::calculatePoints(false, $client, $total, $to_paye, $base_profit, $base);
                }
            } else {
                return redirect()->back()->with('message', 'Vous pouvez pas utiliser les points de reduction');
            }
        } else {

            InvoiceService::calculatePointsWithoutBalance($total, $client, $store->coeff, $base_profit, $base);
            $use_red_final = $use_red = 0;
        }
        $userId = in_array(auth()->user()->store_id,[19]) && !empty($request->userId ) ? : Auth()->user()->id;
        $invoice_id = InvoiceService::createInvoice(Auth()->user()->store_id, $userId, $use_red, $data);
        Fond::create([
            'store_id'        => $store->id,
            'invoice_id'      => $invoice_id,
            'encasement_type' => 0,
            'encasement_date' => Carbon::now()
        ]);
        //event to send Mail Order to client

        InvoiceService::createInvoicePaiement($invoice_id, $data);
        InvoiceService::createInvoiceProduct($invoice_id, $data, 0);
        $tva = $store->tva;

        $invoice = Invoice::find($invoice_id);
        $invoice->total_ht = $total_ht;
        $invoice->tva = auth()->user()->store->tva;
        $invoice->save();
        if (isset($client->email)) {
            //event(new OrderEvent($client, $invoice, $store));
        }
        $oldInvoice = Invoice::find($id);
        $oldInvoice->status = 4;
        $oldInvoice->save();

        Fond::create([
            'store_id'        => $store->id,
            'invoice_id'      => $oldInvoice->id,
            'encasement_type' => 1,
            'encasement_date' => Carbon::now()
        ]);
        return redirect()->route('employe.invoices');
    }

    public function cancel($id)
    {

        $oldInvoice = Invoice::find($id);
        $client = Customer::find($oldInvoice->customer_id);
        $store = Store::find(auth()->user()->store_id);
        $base = $store->base;
        $base_profit = $store->base_profit;
        if ($oldInvoice->points > 0) {
            $oldPoints =  InvoiceService::calculatePoints(false, $client, $oldInvoice->total, $base_profit, $base);
        } else {
            $oldPoints =  InvoiceService::calculatePoints(true, $client, $oldInvoice->total, $base_profit, $base);
        }
        if ($client->points - $oldPoints <= 0) {
            $client->points = 0;
            $client->save();
        } else {
            $client->points = (int) ($client->points - $oldPoints);
            $client->save();
        }
        InvoiceService::cancelInvoice($id);
        Fond::create([
            'store_id'        => $store->id,
            'invoice_id'      => $oldInvoice->id,
            'encasement_type' => 1,
            'encasement_date' => Carbon::now()
        ]);

        return redirect()->back();
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

    protected function calculatePoints($total, $base_profit, $base)
    {
    }

    public function getCanceledInvoices($items = 25)
    {

        $items = (isset($_GET['items'])) ? $_GET['items'] : $items;
        $stores_id = [];
        $total = 0;
        foreach (auth()->user()->stores as $store)
            array_push($stores_id, $store->id);
        (isset($_GET['start_date']) && isset($_GET['end_date'])) ? $invoices = Invoice::whereIn('store_id', $stores_id)->whereBetween('invoice_date', [$_GET['start_date'], $_GET['end_date']])->where('status', '=', 2)->paginate($items)  : $invoices = Invoice::whereIn('store_id', $stores_id)->where('status', '=', 2)->paginate($items);

        foreach ($invoices as $invoice)
            $total = $total + $invoice->total;
        return view('owner.invoices.canceled', compact('invoices', 'total'));
    }
}
