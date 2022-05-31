<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\CampaignService;
use App\Services\CustomerService;
use App\Services\InvoiceService;
use App\Services\MenuService;
use App\Services\ProductService;
use Illuminate\Http\Request;

use function Psy\debug;

class PosController extends Controller
{
    public $customerService;
    protected $productService;
    protected $menuService;
    protected $campaignService;
    protected $invoiceService;
    public function __construct()
    {
        $this->customerService = new CustomerService;
        $this->productService = new ProductService;
        $this->menuService = new MenuService;
        $this->campaignService = new CampaignService;
        $this->invoiceService = new InvoiceService;

    }

    public function index()
    {
    }

    public function create()
    {

        $customers =  $this->customerService
            ->getSharedCustomer(auth()->user()->store->owner)->map(function ($customer) {
                return $customer->only(['id', 'phone', 'firstname', 'lastname']);
            });
        $products = $this->productService->index()->where('menu_id','!=',null)->groupBy('menu_id');
        $menus = $this->menuService->all();
        dd($menus->toArray(),$products);
        return view('employe.pos.create', ['customers' => $customers,'products'=> $products,'menus'=>$menus ]);
    }

    public function getProductByMenuId(Request $request){
       return  $this->productService->index()->where('menu_id','=',$request->menu_id);
    }

    public function store(Request $request){
       
        $totalHt      = $this->productService->getTotalHt($request->productsId);
        $total        = $this->productService->getTotal($totalHt);
        $customer     = $this->customerService->getCustomerById($request->customerId);
        $useRedFinal  = $customer->points;
        $pointsWithoutDiscount=0;
        $useRed = 0;
        if($request->isUseReduction == true){
             $total   = $this->productService->getTotalHtWithReduction($totalHt,$customer);
             $useRed  =  $this->invoiceService->updatePoints($total, $customer);
        }else {
            $pointsWithoutDiscount = $this->invoiceService->updatePointsWithoutBalance($total, $customer);
            $useRedFinal = $useRed = 0;
        }
        return [$total,$totalHt, $pointsWithoutDiscount,$useRedFinal,$useRed];
    }

    


    public function edit()
    {
        return 3;
    }


     // if(!empty($request->code)){
        //     $res =  $this->campaignService->getCampaignHistoriqueByCodeAndCustomerId($request->code, $customer->id);
        //     $total  = $request->total;
        // }
}
