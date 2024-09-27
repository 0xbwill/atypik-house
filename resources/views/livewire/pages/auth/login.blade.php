<?php

use App\Livewire\Forms\LoginForm;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Illuminate\Validation\ValidationException;

new #[Layout('layouts.guest')] class extends Component {
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $validated = $this->validate([
            'form.email' => ['required', 'string', 'email', 'max:255'],
            'form.password' => ['required', 'string', 'min:8'],
        ], [
            'form.email.required' => "L'adresse e-mail est obligatoire.",
            'form.email.string' => "L'adresse e-mail doit être une chaîne de caractères.",
            'form.email.email' => "L'adresse e-mail n'est pas valide.",
            'form.email.max' => "L'adresse e-mail ne peut pas dépasser 255 caractères.",

            'form.password.required' => 'Le mot de passe est obligatoire.',
            'form.password.string' => 'Le mot de passe doit être une chaîne de caractères.',
            'form.password.min' => 'Le mot de passe doit contenir au moins :min caractères.',
        ]);

        try {
            // Tentative d'authentification
            $this->form->authenticate();
            Session::regenerate();

            // Redirection après une connexion réussie
            $this->redirectIntended(default: RouteServiceProvider::HOME);
        } catch (ValidationException $e) {
            // Gestion de l'échec de l'authentification avec un message personnalisé
            $this->addError('form.email', __('Les identifiants fournis sont incorrects.'));
        }
    }
};
?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <a style="display: flex" class="logo justify-center" href="{{ route('home.index') }}" wire:navigate>
                <img class="w-64 mb-4" src="{{ url('/images/logo full.png') }}" alt="Logo">
            </a>
            <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Espace de connexion</h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form wire:submit="login">
                <!-- Email Address -->
                <div>
                    <x-input-label class="mb-2" for="email" :value="__('Adresse email')" />
                    <input wire:model="form.email" id="email"
                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-300 sm:text-sm sm:leading-6"
                        type="email" name="email" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <div class="flex items-center justify-between">
                        <x-input-label for="password" :value="__('Mot de passe')" />
                        <div class="text-sm">
                            <a href="{{ route('password.request')}}" class="font-semibold text-vert hover:text-vert_hover">Mot de passe oublié ?</a>
                        </div>
                    </div>
                    <div class="mt-2">
                        <input wire:model="form.password" id="password"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-300 sm:text-sm sm:leading-6"
                            type="password" name="password" required autocomplete="current-password" />

                        <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
                    </div>
                </div>

                <div class="mt-4">
                    <button role="button" aria-label="filtre" class="flex w-full justify-center rounded-md bg-vert px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-vert_hover focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        {{ __('Connexion') }}
                    </button>
                </div>
            </form>

            <p class="mt-10 text-center text-sm text-gray-500">
                Si vous n'avez pas de compte, vous pouvez en créer un en cliquant
                <a href="{{ route('register')}}" class="font-semibold leading-6 text-vert hover:text-vert_hover">ici.</a>
            </p>
        </div>
    </div>
</div>
