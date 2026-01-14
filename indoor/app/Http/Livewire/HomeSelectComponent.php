<?php

namespace App\Http\Livewire;

use Livewire\Component;

class HomeSelectComponent extends Component
{
    public $selectOptionText = 'Select Service Type';

    public $options1;

    public function mount($selectOptionText = null)
    {
        $this->selectOptionText = $selectOptionText ?: 'Select Service Type';
        $this->initializeOptions1();
    }

    public function initializeOptions1()
    {
        // Initialize other options if needed
        $this->options1[1] = 'Tornoto';
        $this->options1[2] = 'Texas';
    }

    public function render()
    {
        return view('livewire.home-select-component');
    }
}
