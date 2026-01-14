<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ServiceSelectComponent extends Component
{
    public $selectedItems = [];

    public function render()
    {
        return view('livewire.service-select-component', [
            'items' => ['Price Low to High', 'Price High to Low'],
        ]);
    }
}
