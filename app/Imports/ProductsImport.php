<?php

namespace App\Imports;

use App\Models\Menu;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Product;
use App\Services\MenuService;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ProductsImport implements ToCollection,WithDrawings
{
    protected $store_id;
    protected $menuService;
    public function __construct($store_id)
    {
        $this->store_id = $store_id;
        $this->menuService = new MenuService;
    }
    /**
     * @param Collection $collection
     */
    public function collection($rows)
    {
        unset($rows[0]);
        if ($rows->first()->count() == 6) {
            $rows->groupBy(5)->map(function ($row,$key) {
                $menu =  $this->menuService->create([ 'store_id'=>$this->store_id,'name'=>$key]);
                $row->map(function ($el) use($menu) {
                    Product::create([
                        'store_id' => $this->store_id,
                        'menu_id' => $menu->id,
                        'label' => $el[0],
                        'price' => $el[1],
                        'promotion_price' => $el[2],
                        'quantite' => $el[3],
                    ]);   
                });
            });
        } else {
            $menu = [];
            foreach ($rows as $key => $row) {
                if (isset($row[2])) {
                    Product::create([
                        'store_id' => $this->store_id,
                        'label' => $row[0],
                        'price' => $row[1],
                        'promotion_price' => $row[2],
                        'quantite' => $row[3],
                    ]);
                }
            }
        }
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is my logo');
        $drawing->setPath(public_path('/img/products/'.$this->store_id.'/vir.png'));
        $drawing->setHeight(90);
        $drawing->setCoordinates('B3');

        return $drawing;
    }
}
