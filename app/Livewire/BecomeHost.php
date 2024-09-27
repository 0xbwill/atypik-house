<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\HostRequest;
use App\Mail\BecomeHost\FormSubmitConfirmation;
use App\Mail\BecomeHost\AdminNewHostRequest;
use Illuminate\Support\Facades\Mail;

class BecomeHost extends Component
{
    public $name;
    public $email;
    public $message;
    public $alertType;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'message' => 'required|string',
    ];

    public function submit()
    {
        if (HostRequest::where('user_id', Auth::id())->exists()) {
            $this->alertType = 'error';
            session()->flash('status', 'Vous avez déjà soumis une demande pour devenir hôte.');
            return;
        }
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'message' => $this->message,
        ];

        HostRequest::create([
            'user_id' => Auth::id(),
            'name' => $data['name'],
            'email' => $data['email'],
            'message' => $data['message'],
        ]);

        $this->alertType = 'success';

        // Envoyer un email de confirmation à l'utilisateur
        Mail::to($data['email'])->send(new FormSubmitConfirmation());

        // Envoyer un email aux administrateurs
        Mail::to('contact@atypikhouse.site')->send(new AdminNewHostRequest($data));

        session()->flash('status', 'Votre demande a été soumise avec succès!');

        return redirect()->route('devenir-hote');
    }

    public function render()
    {
        return view('livewire.components.become-host');
    }
}
