<?php

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
//use Session;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/command',function(){
    // Artisan::call('launch:campaign');
     Artisan::call('optimize:clear');
    return "Cache is cleared";
     
 });
 
 Route::get('send-sms',function(){
    
            $num      ="0675295551";

            $texte    ="Hello Folks! happy coding";

            $emetteur ="MORINO";

            $url = 'https://bulksms.ma/developer/sms/send';
                                                                                                
        
            $fields_string = 'token=a4B2EZpCjP72JwA33JRTwYQ1e&tel=0675295551&message=LastDay&shortcode=MORINO';
            
            $ch = curl_init();
        
            curl_setopt($ch, CURLOPT_URL, $url);
           // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        
            $result = curl_exec($ch);
        
            curl_close($ch);
            return $result; 
 });


Route::group(['domain' => 'sherin.loc'], function () {

Route::get('/', function () {
     return view('welcome');
    //return redirect()->route('index');
})->name('/');
  
Route::post('/contact-us','HomeController@contactUs')->name('contactus');

});
Route::group(['domain' => 'www.sherin.loc'], function () {

Route::post('/contact-us','HomeController@contactUs')->name('contactus');

Route::get('/', function () {
     return view('welcome');
})->name('/');
  
    
});

//app.sherin.loc

Route::group(['domain' => 'sherin-old.herokuapp.com'], function () {
    
    //Language Change
Route::get('lang/{locale}', function ($lang) {
    \Session::put('locale',$lang);
    return redirect()->back();
  
})->name('lang');
    


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('dashboard/index',function(){
    return view('dashboard.index');
})->middleware(['auth','admin','lang'])->name('index');
Route::get('dashboard/owner', 'Web\OwnerController@getDashboard')->middleware(['auth','active','owner','lang'])->name('owner.dashboard');
Route::get('dashboard/employe', 'Web\EmployerController@getDashboard')->middleware(['auth','active','employer','lang'])->name('employ.dashboard');

Route::prefix('')->group(function () {
    Route::view('/', 'authentication.login')->name('authentication.login');
    Route::post('/login','Auth\AuthController@login')->name('auth.login');
    Route::view('forget-password', 'authentication.forget-password')->name('forget-password');
    Route::view('reset-password', 'authentication.reset-password')->name('reset-password');
    Route::get('/checkout','CheckoutController@index')->name('hold');
    Route::get('/payement','Web\PayementController@pay');
    Route::get('/payment/validate','Web\PayementController@checkout');
});

Route::get('/hold-account-message','Web\SmsController@getData')->middleware('auth','lang')->name('holdAccount.message');

Route::prefix('admin')->namespace('Web')->name('admin')->middleware('auth','lang','admin')->group(function(Illuminate\Routing\Router $router){
    /**Admin Owner Routes */

    $router->get('this-month-customers-solde','CustomerController@getCustomersTarget');
    $router->get('owners','OwnerController@index')->name('.owners');
    $router->get('owners/{id}/edit','OwnerController@edit')->name('.edit.owner');
    $router->get('owners/{id}/delete','OwnerController@destroy')->name('.destroy.owners');
    $router->get('owners/{id}/active','OwnerController@active')->name('.active.owners');
    $router->post('/owners/store','OwnerController@store')->name('.store.owner');
    $router->post('/owner/{id}/update','OwnerController@update')->name('.update.owner');
    /**End of Admin Owner Routes */
    /** Admin Activity Routes */
    $router->get('/activities','ActivityController@index')->name('.activities');
    $router->post('/activities/store','ActivityController@store')->name('.store.activities');
    $router->get('/activities/{id}/edit','ActivityController@edit')->name('.edit.activities');
    $router->post('/activities/{id}/update','ActivityController@update')->name('.update.activities');
    /** End of Admin Activity Routes */

    /**Admin Stores Routes */
    $router->get('/stores','StoreController@index')->name('.stores');
    $router->post('/stores/store','StoreController@store')->name('.stores.store');
    $router->get('/stores/{id}/edit','StoreController@edit')->name('.stores.edit');
    $router->post('/stores/{id}/update','StoreController@update')->name('.stores.update');
    $router->get('/stores/{id}/delete','StoreController@destroy')->name('.stores.delete');
    $router->get('/stores/{id}/active','StoreController@activate')->name('.stores.activate');
    /**End of Admin Stores Routes */

    /**Admin products Routes */
    $router->get('products','ProductController@index')->name('.products');
    $router->get('products/{id}/edit','ProductController@edit')->name('.products.edit');
    $router->post('products/{id}/update','ProductController@update')->name('.products.update');
    $router->post('products/store','ProductController@store')->name('.products.store');
    $router->post('/products/import','ProductController@import')->name('.import.products');

    $router->get('menus','MenuController@index')->name('.menus');
    /**End Admin products Routes */

     /**Admin Employees Routes */
     $router->get('employees','EmployerController@index')->name('.employees');
     $router->post('employees/store','EmployerController@store')->name('.employees.store');
     /**End of Admin Employees Routes */

   

     /**Admin Templates Routes */
     $router->get('templates','TemplateController@index')->name('.templates');
     $router->post('templates/store','TemplateController@store')->name('.templates.store');
     $router->get('templates/{id}/edit','TemplateController@edit')->name('.templates.edit');
     $router->post('templates/{id}/update','TemplateController@update')->name('.templates.update');


     /**End of Admin Templates Routes */

    /**Campaigns Routes*/
    $router->get('campaigns','CampaignController@index')->name('.campaigns');
    $router->post('campaigns/store','CampaignController@store')->name('.campaigns.store');
    $router->get('sms-campaign','SmsController@index')->name('.sms.campaign');
    $router->view('sms-campaigns','admin.sms.campaigns')->name('.sms.campaigns');
    $router->view('sms-uniques','admin.sms.uniques')->name('.sms.uniques');
    $router->view('unique','admin.sms.unique')->name('.unique');
    $router->get('/campaign/message','CampaignController@getCampaignMessage')->name('.campaign.message');
    $router->get('/campaign/sms/stores','SmsController@getStoresByOwner')->name('.campaign.stores');
    $router->get('/campaign/sms/customers','SmsController@getCustomersByStore')->name('.campaign.customers');
    $router->get('/email-campaign','NewsLetterController@createCampaign')->name('.campaign.newsletter.create');
    $router->get('/email-campaigns','NewsLetterController@index')->name('.campaign.newsletter');
    $router->view('/newsLetter-1','newsletter.model-1')->name('.model-1');


    /**Routes of Admin Account */
    $router->view('access','admin.account.access')->name('.access');
    $router->view('personal','admin.account.personal')->name('.personal');
    $router->view('inbox','admin.inbox.list')->name('.inbox');

    /**Routes of SMS  */
    $router->post('/sendSms','SmsController@store')->name('.sendSms');
    /**Route of repports  */
    $router->view('campaign-report','admin.report.campaign')->name('.report.campaign');
    $router->view('sms-report','admin.report.sms')->name('.report.sms');
    $router->view('charge-report','admin.report.charge')->name('.report.charge');
    $router->post('single-campaign','CampaignController@singleCampaign')->name('.single-campaign');
    
});

Route::prefix('owner')->namespace('Web')->name('owner')->middleware('auth','active','owner','lang')->group(function(Illuminate\Routing\Router $router){
   
   // $router->get('/chart-spin','OwnerController@getChartSpin');
 

    /**Admin Stores Routes */
    $router->get('/stores/','StoreController@index')->name('.stores');
    $router->get('/stores/{id}/edit','StoreController@edit')->name('.stores.edit');
    $router->post('/stores/{id}/update','StoreController@update')->name('.stores.update');
    $router->get('/stores/{id}/delete','StoreController@destroy')->name('.stores.delete');
    $router->get('/stores/{id}/active','StoreController@activate')->name('.stores.activate');
    /**End of Admin Stores Routes */

    /**Admin products Routes */
    $router->get('products','ProductController@index')->name('.products');
    $router->get('products/{id}/edit','ProductController@edit')->name('.products.edit');
    $router->post('products/{id}/update','ProductController@update')->name('.products.update');
    $router->post('products/store','ProductController@store')->name('.products.store');
    $router->post('/products/import','ProductController@import')->name('.import.products');
    /**End Admin products Routes */

    $router->get('/invoices','InvoiceController@getOwnerInvoices')->name('.invoices');
    $router->get('/invoices/canceled','InvoiceController@getCanceledInvoices')->name('.invoices.canceled');
     /**Admin Employees Routes */
     $router->get('employees','EmployerController@index')->name('.employees');
     $router->post('employees/store','EmployerController@store')->name('.employees.store');
     /**End of Admin Employees Routes */

      /**Route of employers objectives */
    $router->get('objectives','EmployerController@objectives')->name('.objectives');
     /**End of employers objectives */
    $router->view('access','admin.account.access')->name('.access');
    $router->view('personal','admin.account.personal')->name('.personal');
    $router->view('inbox','admin.inbox.list')->name('.inbox');
    $router->get('/solde','OwnerController@getSoldeDetail')->name('.solde');

    /**Routes of SMS  */

    /**Route of repports  */
    $router->view('campaign-report','admin.report.campaign')->name('.report.campaign');
    $router->view('sms-report','admin.report.sms')->name('.report.sms');
    $router->view('charge-report','admin.report.charge')->name('.report.charge');
    //evolution TurnOver by month &  Evolution Numbre of Clients Consommation Of BR par mois / magasin 	
    $router->get('/chart-data/{type}','OwnerController@getChartData')->name('.chart');
    $router->get('/repport','OwnerController@getRepportData')->name('.chart');
    $router->get('/repport/turnOver','OwnerController@getTurnOver')->name('.chart.turnOver');
    
    $router->get('caisse','CaisseController@index')->name('.caisse.index');
    $router->post('initial-fonds','InitialFondController@store')->name('.initial-fonds.store');
    $router->post('single-campaign','CampaignController@singleCampaign')->name('.singleCamp');
    $router->get('/repport/invoices','RepportController@getInvoices')->name('.invoices.repport');
    $router->get('/repport/customers','RepportController@getCustomers')->name('.customers.repport');
    $router->get('/repport/products','RepportController@getProducts')->name('.products.repport');
    $router->get('/campaigns','RepportController@getCampaigns')->name('.campaigns.repport');
    $router->get('/returns','InvoiceController@getReturns')->name('.invoices.returns');
});

Route::prefix('employe')->namespace('Web')->name('employe')->middleware('auth','active','employer','lang')->group(function(Illuminate\Routing\Router $router){
   


    /**Employe products Routes */
    $router->get('products','ProductController@index')->name('.products');
    /**End Employe products Routes */
    /**Employe invoices Routes */
    $router->get('invoices','InvoiceController@index')->name('.invoices');
    $router->get('invoices/products','InvoiceController@renderProductRow');
    $router->get('invoices/create','InvoiceController@create')->name('.invoices.create');

    $router->get('poss','PosController@index')->name('.poss');
    $router->get('pos/products','PosController@renderProductRow');
    $router->get('pos/create','PosController@create')->name('.pos.create');
    $router->post('pos/store','PosController@store')->name('.pos.store');



    $router->post('invoices/store','InvoiceController@store')->name('.invoices.store');
    $router->get('invoices/{id}/edit','InvoiceController@edit')->name('.invoices.edit');
    $router->get('invoices/{id}/show','InvoiceController@show')->name('.invoices.show');
    $router->post('invoices/{id}/update','InvoiceController@update')->name('.invoices.update');
    $router->get('invoices/{id}/print','InvoiceController@print')->name('.invoices.print');
    $router->get('invoices/{id}/cancel','InvoiceController@cancel')->name('.invoices.cancel');
    /**Employe Customers Routes */
    $router->get('customers','CustomerController@index')->name('.customers');
    $router->get('customers/create','CustomerController@create')->name('.customers.create');
    $router->post('customers/store','CustomerController@store')->name('.customers.store');
    $router->get('customers/{id}/edit','CustomerController@edit')->name('.customers.edit');
    $router->post('customers/{id}/update','CustomerController@update')->name('.customers.update');
    $router->get('customers/points','CustomerController@getCustomerPoints')->name('.customers.points');
    $router->get('products/menu','PosController@getProductByMenuId')->name('.products.menus');
    /** End of Employe Customers Routes */
    /** Employe Products Routes */
    $router->get('/product/price','ProductController@getPrice')->name('.productPrice');

    /**end of Employe Products Routes  */
    $router->get('/customer/code/red','CustomerController@getCustomerRed');
     
    $router->view('access','admin.account.access')->name('.access');
    $router->view('personal','admin.account.personal')->name('.personal');
    $router->view('inbox','admin.inbox.list')->name('.inbox');
    $router->get('caisse','CaisseController@getCaisseEmployee')->name('.caisse.index');
    $router->get('/initial-fonds','InitialFondController@index')->name('.initial-fonds.index');
    $router->post('/initial-fonds/store','InitialFondController@store')->name('.initial-fonds.store');
     $router->post('/invoice-return','InvoiceController@returnInvoice')->name('.invoices.return');
    
});

Route::prefix('auth')->namespace('Auth')->middleware('auth')->group(function(Illuminate\Routing\Router $router){
    $router->post('/update-personal-info','UserAuthController@updateAuthInfo')->name('personal.info.update');
    
    $router->post('/update-access-info','UserAuthController@updateAuthAccess')->name('personal.access.update');
});

Route::view('/template-invoice','template');

});
