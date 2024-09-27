<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\DatesDisponibles;
use Carbon\Carbon;

class ManageDates extends Component
{
    public $logement;
    public $datesDuLogement = [];
    public $selectedDates = [];

    public function mount($logement)
    {
        $this->logement = $logement;
        $this->loadDates();
    }

    public function loadDates()
    {
        $this->datesDuLogement = $this->logement->datesDispos()->get()->map(function($date) {
            return [
                'id' => $date->id,
                'debut_dispo' => Carbon::parse($date->debut_dispo)->format('d/m/Y'),
                'fin_dispo' => Carbon::parse($date->fin_dispo)->format('d/m/Y'),
            ];
        });
    }

    public function updateDates($selectedDates)
    {
        $this->selectedDates = $selectedDates;

        if (count($this->selectedDates) == 2) {
            DatesDisponibles::create([
                'debut_dispo' => Carbon::parse($this->selectedDates[0])->toDateString(),
                'fin_dispo' => Carbon::parse($this->selectedDates[1])->toDateString(),
                'logement_id' => $this->logement->id,
            ]);

            // Rafraîchir les dates disponibles
            $this->loadDates();

            // Envoyer un message de succès à la session
            session()->flash('message', 'Créneau ajouté avec succès');
        }
    }

    public function deleteDate($dateId)
    {
        DatesDisponibles::findOrFail($dateId)->delete();

        // Rafraîchir les dates disponibles
        $this->loadDates();

        // Envoyer un message de succès à la session
        session()->flash('message', 'Créneau supprimé avec succès');
    }

    public function render()
    {
        return view('livewire.manage-dates');
    }
}