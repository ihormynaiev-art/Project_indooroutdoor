<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ProviderPlanSelectComponent extends Component
{
    public $selectedOption1;

    public $options1;

    public function mount()
    {
        $this->options1 = ['A -> Z', 'Most helful'];
    }

    public function render()
    {
        return view('livewire.provider-plan-select-component');
    }
}
