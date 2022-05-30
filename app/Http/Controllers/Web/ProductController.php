<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Store;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($items = 25)
    {
        (isset($_GET['items'])) ? $items = $_GET['items'] : $items = 25;
        if (auth()->user()->is_admin == 1) {
            $products = Product::OrderBy('id', 'DESC')->paginate($items);
            $stores = Store::where('status', '=', 1)->get();
            return view('admin.products.list', compact('products', 'stores'));
        } elseif (auth()->user()->is_admin == 2) {

            $stores = Store::where('status', '=', 1)->where('user_id', '=', auth()->user()->id)->orderBy('id', 'DESC')->paginate($items);
            $stores_id = [];
            foreach ($stores as $str)
                array_push($stores_id, $str->id);
            $products = Product::whereIn('store_id', $stores_id)->orderBy('id', 'DESC')->get();
            return view('owner.products.list', compact('products', 'stores'));
        } elseif (auth()->user()->is_admin == 3) {
            $products = Product::where('store_id', '=', auth()->user()->store_id)->orderBy('id', 'DESC')->paginate($items);
            $stores = Store::where('id', '=', auth()->user()->store_id)->get();
            return view('employe.products.list', compact('products', 'stores'));
        }
    }

    public function getPrice(Request $request)
    {
        return Product::find($request->productId);
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
        Product::create([
            'store_id' => $request->store_id,
            'label' => $request->label,
            'price' => $request->price,
            'promotion_price' => $request->promotion_price,
            'quantite' => $request->quantite
        ]);
        return redirect()->route('admin.products');
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
        $product = Product::findOrFail($id);
        $stores = Store::where('status', '=', 1)->get();
        return view('admin.products.edit', compact('product', 'stores'));
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
        $product = Product::findOrFail($id);
        $updatedProduct = $request->all();
        if ($request->hasFile('image')) {
            $updatedProduct['image'] = $request->image->getClientOriginalName();
            $this->move_files($request->image,  $product['store_id']);
        }
        $product->update($updatedProduct);
        if (auth()->user()->is_admin == 1)
            return redirect()->route('admin.products');
        else
            return redirect()->route('owner.products');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function import(Request $request)
    {

        $path1 = $request->file('products')->store('temp');
        $path = storage_path('app') . '/' . $path1;
        $store_id = $request->store_id;
        Excel::import(new ProductsImport($store_id), $path);
        return redirect()->route('admin.products');
    }

    /* 
    * Function Move the File uploaded to new directory
    */
    protected function move_files($file, $id)
    {

        $destinationPath = 'uploads/products/' . $id . '/';
        //move each file to destination path
        $file->move($destinationPath, $file->getClientOriginalName());
        $file_names = $file->getClientOriginalName();
        return $file_names;
    }
}
