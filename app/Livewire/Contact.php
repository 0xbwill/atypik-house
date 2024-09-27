<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

class Contact extends Component
{
    public $nom;
    public $prenom;
    public $telephone;
    public $email;
    public $message; // Gardons ce nom ici

    protected $rules = [
        'nom' => 'required|string|min:3',
        'prenom' => 'required|string|min:3',
        'telephone' => 'required|numeric',
        'email' => 'required|email',
        'message' => 'required|string|min:10',
    ];

    protected $messages = [
        'nom.required' => 'Le champ nom est obligatoire.',
        'nom.min' => 'Le nom doit comporter au moins 3 caractères.',
        'prenom.required' => 'Le champ prénom est obligatoire.',
        'prenom.min' => 'Le prénom doit comporter au moins 3 caractères.',
        'telephone.required' => 'Le champ téléphone est obligatoire.',
        'telephone.numeric' => 'Le numéro de téléphone doit être un nombre.',
        'email.required' => 'Le champ email est obligatoire.',
        'email.email' => 'L\'adresse email doit être valide.',
        'message.required' => 'Le champ message est obligatoire.',
        'message.min' => 'Le message doit comporter au moins 10 caractères.',
    ];

    public function submit()
    {
        $this->validate();

        // Envoyer l'email
        Mail::to('contact@atypikhouse.site')->send(new ContactFormMail(
            $this->nom, 
            $this->prenom, 
            $this->telephone, 
            $this->email, 
            $this->message // Passons-le en tant que formMessage
        ));

        session()->flash('message', 'Votre message a été envoyé avec succès !');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.components.contact');
    }
}
