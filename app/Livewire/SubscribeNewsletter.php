<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Subscriber;
use App\Mail\NewsletterEmail;
use Illuminate\Support\Facades\Mail;
use Spatie\Newsletter\Facades\Newsletter;


class SubscribeNewsletter extends Component
{
    

    public $email;

    protected $rules = [
        'email' => 'required|email|unique:subscribers,email',
    ];

    // Définir des messages de validation personnalisés
    protected function messages()
    {
        return [
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'Veuillez entrer une adresse email valide.',
            'email.unique' => 'Cet email est déjà inscrit à notre newsletter.',
        ];
    }

    public function submit()
    {
        // Validation
        $this->validate();

        // Créer un nouvel abonné
        $subscriber = Subscriber::create([
            'email' => $this->email,
        ]);

        $email = $this->email;

        // Envoyer un email de confirmation
        Mail::to($subscriber->email)->send(new NewsletterEmail($subscriber));

        Newsletter::subscribe($email);

        // Message de confirmation
        session()->flash('message', 'Merci pour votre abonnement à la newsletter.');

        // Réinitialiser le champ email
        $this->reset('email');
    }

    public function render()
    {
        return view('livewire.subscribe-newsletter');
    }
}
