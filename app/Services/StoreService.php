<?php 
namespace App\Services;
use App\Models\Store;
class StoreService 
{
    /**
     * @return Collection
     */
  public function getAll()
  {
    return Store::orderBy('id','DESC')->get();
  }
        
}