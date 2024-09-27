<?php
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Spatie\Permission\Models\Role;
use Illuminate\Database\QueryException; // Import for handling query exceptions
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'min:8', 'confirmed', Rules\Password::defaults()->numbers()->symbols()],
        ], [
            'name.required' => 'Le prénom est obligatoire.',
            'name.string' => 'Le prénom doit être une chaîne de caractères.',
            'name.max' => 'Le prénom ne peut pas dépasser 255 caractères.',
            
            'email.required' => "L'adresse e-mail est obligatoire.",
            'email.string' => "L'adresse e-mail doit être une chaîne de caractères.",
            'email.lowercase' => "L'adresse e-mail doit être en minuscules.",
            'email.email' => "L'adresse e-mail n'est pas valide.",
            'email.max' => "L'adresse e-mail ne peut pas dépasser 255 caractères.",
            'email.unique' => "L'adresse e-mail est déjà utilisée.",

            'password.required' => 'Le mot de passe est obligatoire.',
            'password.string' => 'Le mot de passe doit être une chaîne de caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            'password.min' => 'Le mot de passe doit contenir au moins :min caractères.',
            'password.uppercase' => 'Le mot de passe doit contenir au moins une lettre majuscule.',
            'password.lowercase' => 'Le mot de passe doit contenir au moins une lettre minuscule.',
            'password.numbers' => 'Le mot de passe doit contenir au moins un chiffre.',
            'password.symbols' => 'Le mot de passe doit contenir au moins un caractère spécial.',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        try {
            $user = User::create($validated);

            $user->assignRole('user');

            event(new Registered($user));

            Auth::login($user);

            // Envoyer l'e-mail de bienvenue
            Mail::to($user->email)->send(new WelcomeEmail($user));

            $this->redirect(RouteServiceProvider::HOME, navigate: false);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 19) {
                $this->addError('email', __('L\'adresse e-mail est déjà utilisée.'));
            } else {
                throw $e;
            }
        }
    }
};
?>

<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <a style="display: flex" class="logo justify-center" href="{{ route('home.index') }}" wire:navigate>
            <img class="w-64 mb-4" src="{{ url('/images/logo full.png') }}" alt="Logo">
        </a>
        <h2 class="mb-8 mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Créer un compte</h2>
    </div>
    <form wire:submit="register">
        <!-- Name -->
        <div>
            <x-input-label class="mb-2" for="name" :value="__('Prénom')" />
            <input wire:model="name" id="name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-300 sm:text-sm sm:leading-6" type="text" name="name" required
                autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label class="mb-2" for="email" :value="__('Email')" />
            <input wire:model="email" id="email" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-300 sm:text-sm sm:leading-6" type="email" name="email"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label class="mb-2" for="password" :value="__('Mot de passe')" />

            <input wire:model="password" id="password" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-300 sm:text-sm sm:leading-6" type="password" name="password"
                required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4 mb-8">
            <x-input-label class="mb-2" for="password_confirmation" :value="__('Confirmer mot de passe')" />

            <input wire:model="password_confirmation" id="password_confirmation" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-300 sm:text-sm sm:leading-6"
                type="password" name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <button role="button" aria-label="filtre" class="flex w-full justify-center rounded-md bg-vert px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-vert_hover focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                {{ __('Créer un compte') }}
            </button>
        </div>
    </form>
    <p class="mt-4 text-center text-sm text-gray-500">Déjà inscris ?
        <a class="text-sm text-gray-600 underline rounded-md dark:text-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
            {{ __(' Connexion') }}
        </a>
     </p>
</div>
