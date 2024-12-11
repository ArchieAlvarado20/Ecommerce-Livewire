<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
#[Title('Order Page - Ecommerce')]
class MyOrdersPage extends Component
{
    public function render()
    {
        return view('livewire.my-orders-page');
    }
}
