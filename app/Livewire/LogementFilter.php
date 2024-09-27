<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\CategoryLogement;
use App\Models\Logement;

class LogementFilter extends Component
{
    public $categories;
    public $selectedCategory = null;

    public function mount()
    {
        $this->categories = CategoryLogement::all();
    }

    public function updatedSelectedCategory()
    {
        $this->emit('categorySelected', $this->selectedCategory);
    }

    public function render()
    {
        return view('livewire.logement-filter');
    }
}

