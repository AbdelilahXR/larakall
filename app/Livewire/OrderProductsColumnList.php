<?php
 
namespace App\Livewire;
 
use App\Models\Product;
use App\Models\OrderProduct;
use Illuminate\Contracts\View\View;
use Livewire\Component;
 
class OrderProductsColumnList extends Component
{
    public $orderProducts;
    public $order;
    
    public function mount($selectedRecord)
    {
        $this->order = $selectedRecord;
        $this->orderProducts = OrderProduct::where('orders_id', $selectedRecord->id)->with('products')->get();
    }

    public function getParentProduct($parentid)
    {
        if($parentid == null) return '';
        return Product::where('id', $parentid)->first()->name;
    }


    public function render(): View
    {
        return view('livewire.order-products-column-list');
    }
}