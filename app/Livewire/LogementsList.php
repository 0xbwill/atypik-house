<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Logement;
use App\Models\CategoryLogement;
use Illuminate\Support\Facades\DB;

class LogementsList extends Component
{
    use WithPagination;

    public $perPage = 9; // Nombre de logements par page
    public $priceMin;
    public $priceMax;
    public $capacity;
    public $bedrooms;
    public $bathrooms;
    public $city;
    public $category;
    public $petAllowed = '';

    // Réinitialiser la pagination quand un filtre est mis à jour
    public function updating($field)
    {
        $this->resetPage();
    }

    public function applyFilters()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->category = '';
        $this->priceMin = '';
        $this->priceMax = '';
        $this->capacity = '';
        $this->bedrooms = '';
        $this->bathrooms = '';
        $this->city = '';
        $this->petAllowed = '';

        // Réinitialiser les résultats ou appliquer les filtres par défaut
        $this->applyFilters();
    }

    public function render()
    {
        $query = Logement::where('published', 1)
            ->with('avis')
            ->leftJoin('avis', 'logements.id', '=', 'avis.logement_id')
            ->select('logements.*', DB::raw('AVG(avis.rating) as average_rating'))
            ->groupBy('logements.id');

        // Appliquer les filtres
        if ($this->priceMin) $query->where('price', '>=', (float)$this->priceMin);
        if ($this->priceMax) $query->where('price', '<=', (float)$this->priceMax);
        if ($this->capacity) $query->where('capacity', '>=', (int)$this->capacity);
        if ($this->bedrooms) $query->where('bedrooms', '>=', (int)$this->bedrooms);
        if ($this->bathrooms) $query->where('bathrooms', '>=', (int)$this->bathrooms);
        if ($this->city) $query->where('city', 'like', '%' . $this->city . '%');
        if ($this->category) $query->whereHas('categoryLogement', fn($q) => $q->where('name', $this->category));
        if ($this->petAllowed) $query->where('pet_allowed', true);

        $paginatedLogements = $query->orderByDesc('average_rating')->paginate($this->perPage);

        $categories = CategoryLogement::all();

        // Ajouter `public_url` à chaque logement
        $paginatedLogements->transform(function ($logement) {
            $logement->public_url = preg_match('/^(http|https):\/\//', $logement->image_url) ? true : false;
            return $logement;
        });

        return view('livewire.logements-list', [
            'paginatedLogements' => $paginatedLogements,
            'categories' => $categories
        ]);
    }
}
