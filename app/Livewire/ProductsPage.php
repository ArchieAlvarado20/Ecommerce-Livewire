<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use livewire\WithPagination;

#[Title('Products- Ecommerce')]

class ProductsPage extends Component
{
    use LivewireAlert;
    use WithPagination;

    #[Url]
    public $selected_categories = [];

    #[Url]
    public $selected_brand = [];

    #[Url]
    public $featured;

    #[Url]
    public $on_sale;

    #[Url]
    public $price_range = 30000;

    #[Url]
    public $sort = 'latest';

    //add product to cart method
    public function addToCart($product_id){
        // dd($product_id);

        $total_count = CartManagement::addItemToCart($product_id);

        $this->dispatch('update-cart-count', total_count: $total_count)->to(Navbar::class);
        
        $this->alert('success', 'Product added to the cart Succefully', [
            'position' => 'bottom-end',
            'timer' => 3000,
            'toast' => true,
            'icon' =>'success',

        ]);
    }

    public function render()
    {
        $products = Product::where('is_active', 1);

        if(!empty($this->selected_categories))
        {
            $products->whereIn('category_id', $this->selected_categories);
        }

        if(!empty($this->selected_brand))
        {
            $products->whereIn('brand_id',  $this->selected_brand);
        }

        if ($this->featured)
        {
            $products->where('is_featured', 1);
        }

        if ($this->on_sale)
        {
            $products->where('on_sale', 1);
        }

        if($this->price_range)
        {
            $products->whereBetween('price',[0, $this->price_range]);
        }

        if($this->sort == 'latest')
        {
            $products->latest();
        }

        if($this->sort == 'price')
        {
            $products->orderBy('price');
        }

        return view('livewire.products-page',[
            'products' => $products->paginate(5),
            'categories' => Category::where('is_active', 1)->get(['id','name','slug']),
            'brands' => Brand::where('is_active',1)->get(['id','name','slug'])
        ]);
    }
}
