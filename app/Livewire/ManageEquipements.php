<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CategoryLogement;
use App\Models\Equipement;
use Illuminate\Support\Facades\Mail;
use App\Mail\EquipementAdded;
use App\Mail\EquipementRemoved;
use App\Models\User;


class ManageEquipements extends Component
{
    public $categories;
    public $allEquipements;
    public $selectedCategoryIds = [];
    public $selectedEquipementIds = [];
    public $showEquipements = [];
    public $selectedEquipementId = null;
    public $categoryToAddEquipement = null;

    public $equipementName;
    public $categoryToEdit;


    public function mount()
    {
        $this->categories = CategoryLogement::with('equipements')->get();
        $this->allEquipements = Equipement::all();

        foreach ($this->categories as $category) {
            $this->selectedCategoryIds[$category->id] = null;
            $this->selectedEquipementIds[$category->id] = null;
        }
    }

    public function addEquipementToCategory()
    {
        $this->validate([
            'selectedEquipementId' => 'required|exists:equipements,id',
            'categoryToAddEquipement' => 'required|exists:category_logement,id',
        ]);

        $equipement = Equipement::find($this->selectedEquipementId);
        $category = CategoryLogement::find($this->categoryToAddEquipement);
        $category->equipements()->attach($equipement->id);

        // Envoyer des emails à tous les hôtes
        $hosts = User::role('hôte')->get();
        foreach ($hosts as $host) {
            Mail::to($host->email)->send(new EquipementAdded($equipement, $category));
        }

        $this->mount(); // Refresh the data

        $this->selectedEquipementId = null;
        $this->categoryToAddEquipement = null;

        session()->flash('message', 'Équipement ajouté avec succès.');
    }

    public function deleteEquipementFromCategory($categoryId, $equipementId)
    {
        $category = CategoryLogement::find($categoryId);
        $equipement = Equipement::find($equipementId);

        $category->equipements()->detach($equipementId);

        // Envoyer des emails à tous les hôtes
        $hosts = User::role('hôte')->get();
        foreach ($hosts as $host) {
            Mail::to($host->email)->send(new EquipementRemoved($equipement, $category));
        }

        $this->mount(); // Refresh the data

        session()->flash('message', 'Équipement supprimé avec succès.');
    }

    public function editEquipement($equipementId)
    {
        $equipement = Equipement::find($equipementId);
        $this->selectedEquipementId = $equipement->id;
        $this->equipementName = $equipement->name;
        $this->categoryToEdit = $equipement->categoriesLogement->first()->id ?? null;
    }

    public function updateEquipement()
    {
        $this->validate([
            'equipementName' => 'required|string',
            'categoryToEdit' => 'required|exists:category_logement,id',
        ]);

        $equipement = Equipement::find($this->selectedEquipementId);
        $equipement->name = $this->equipementName;
        $equipement->save();

        $equipement->categoriesLogement()->sync([$this->categoryToEdit]);

        session()->flash('message', 'Équipement mis à jour avec succès.');
        $this->resetInputFields();
    }

    private function resetInputFields()
    {
        $this->selectedEquipementId = null;
        $this->equipementName = null;
        $this->categoryToEdit = null;
    }


    public function render()
    {
        return view('livewire.manage-equipements');
    }
}
