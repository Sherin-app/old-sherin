<?php
namespace App\Services;
use Illuminate\Support\Facades\Auth;
use App\Models\Menu;
class MenuService {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function all()
    {
        return Menu::where('store_id',auth()->user()->store->id)->get();
    }

    public function getByStoreId($storeId){
        return Menu::where('store_id',$storeId)->get();
    }

    public function create(array $menu){
        return Menu::create($menu);
    }

}
