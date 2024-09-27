<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DatesDisponibles;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DatesDisponiblesController extends Controller
{
    public function getDatesDisponibles($logement_id)
    {
        // Récupérer toutes les dates disponibles pour le logement spécifié
        $datesDisponibles = DatesDisponibles::where('logement_id', $logement_id)->get();

        return response()->json($datesDisponibles);
    }
    public function update(Request $request, $logement_id)
    {
        $validated = $request->validate([
            'logement_id' => 'required|int',
            'debut_dispo' => 'required|date',
            'fin_dispo' => 'required|date'
        ]);


        $dates_dispos = $this->getDatesDisponibles($logement_id);

        $dates_dispos->update($validated);

        return redirect()->route('logement.index', $logement_id)->with('success', 'Dates mis à jour avec succès.');
    }
}
