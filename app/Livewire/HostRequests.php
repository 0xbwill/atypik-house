<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\HostRequest;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Mail;
use App\Mail\BecomeHost\ClientHostAcceptance;
use App\Mail\BecomeHost\ClientHostRejection;
use Illuminate\Support\Facades\Log;

class HostRequests extends Component
{
    public $hostRequests = [];

    public function mount()
    {
        // Charger les demandes d'hôte
        $this->hostRequests = HostRequest::with('user')->get();
    }

    public function accept($id)
    {
        $hostRequest = HostRequest::findOrFail($id);
        $user = $hostRequest->user;

        // Préparer les données pour l'email
        $data = [
            'name' => $hostRequest->name,
            'email' => $hostRequest->email,
            'message' => $hostRequest->message,
        ];

        // Vérifier si le rôle existe
        $hostRole = Role::where('name', 'hôte')->firstOrFail();

        // Remplacer tous les rôles de l'utilisateur par le rôle "hôte"
        $user->syncRoles([$hostRole]);

        // Vérification du rôle attribué
        if ($user->hasRole('hôte')) {
            logger()->info("Le rôle 'hôte' a été attribué à l'utilisateur {$user->id}");
        } else {
            logger()->error("Échec de l'attribution du rôle 'hôte' à l'utilisateur {$user->id}");
        }

        // Supprimer la demande après acceptation
        $hostRequest->delete();

        // Envoyer un email de confirmation à l'utilisateur
        Mail::to($data['email'])->send(new ClientHostAcceptance($data));

        Log::info("Email d'acceptation envoyé à l'utilisateur {$data['email']}");

        // Recharger les demandes d'hôte
        $this->hostRequests = HostRequest::with('user')->get();

        session()->flash('success', 'Demande acceptée et rôle attribué.');
    }

    public function reject($id)
    {
        $hostRequest = HostRequest::findOrFail($id);
        $user = $hostRequest->user;

        // Préparer les données pour l'email
        $data = [
            'name' => $hostRequest->name,
            'email' => $hostRequest->email,
            'message' => $hostRequest->message,
        ];

        Log::info("Tentative d'envoi d'un email de refus à l'utilisateur {$data['email']}");

        $hostRequest->delete(); // Supprime la demande rejetée

        // Envoyer un email de refus au client
        Mail::to($data['email'])->send(new ClientHostRejection($data));

        Log::info("Email de refus envoyé à l'utilisateur {$data['email']}");

        // Recharger les demandes d'hôte
        $this->hostRequests = HostRequest::with('user')->get();

        session()->flash('success', 'Demande rejetée.');
    }

    public function render()
    {
        return view('livewire.host-requests');
    }
}
