<x-app-layout>
    <div class="max-w-3xl mx-auto py-12">
        <h1 class="text-3xl font-bold mb-6 text-center">Paiement de votre réservation</h1>

        <!-- Récapitulatif de la réservation -->
        <div class="bg-gray-100 p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-2xl font-semibold mb-4">Récapitulatif de votre réservation</h2>
            <div class="mb-2">
                <span class="font-semibold">Logement :</span> {{ $logement->title }}
            </div>
            <div class="mb-2">
                <span class="font-semibold">Description :</span> {{ $logement->short_description }}
            </div>
            <div class="mb-2">
                <span class="font-semibold">Adresse :</span> {{ $logement->street }}, {{ $logement->city }},
                {{ $logement->country }} - {{ $logement->postal_code }}
            </div>
            <div class="mb-2">
                <span class="font-semibold">Dates de séjour :</span> du {{ $startDate->format('d/m/Y') }} au
                {{ $endDate->format('d/m/Y') }}
            </div>
            <div class="mb-2">
                <span class="font-semibold">Nombre de nuits :</span> {{ $nights }}
            </div>
            <div class="mb-2">
                <span class="font-semibold">Prix par nuit :</span> {{ number_format($logement->price, 2) }} €
            </div>
            <div class="mb-2">
                <span class="font-semibold">Prix total :</span> {{ number_format($totalAmount, 2) }} €
            </div>
        </div>

        <form id="payment-form" class="bg-white p-8 rounded-lg shadow-md">
            @csrf
            <input type="hidden" name="logement_id" value="{{ $logement->id }}">
            <input type="hidden" name="start_date" value="{{ $startDate }}">
            <input type="hidden" name="end_date" value="{{ $endDate }}">
            <input type="hidden" name="total_amount" value="{{ $totalAmount }}">
            <input type="hidden" name="reservation_id" value="{{ $reservationId }}">
            <!-- Champ caché pour l'ID de la réservation -->
            <input type="hidden" name="payment_method_id" id="payment_method_id">
            <div id="card-element" class="mb-4 p-4 border rounded-lg shadow-sm"></div>
            <button type="submit"
                class="w-full bg-blue-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-600 focus:outline-none focus:bg-blue-600" role="button" aria-label="payer">Payer</button>
            <div id="error-message" class="mt-4 text-red-500"></div>
        </form>


        <!-- Insérez ce code juste en dessous du cadre de paiement -->
        <div style="border: 2px solid #4CAF50; padding: 15px; margin-top: 20px; background-color: #f9f9f9;">
            <h3>Informations pour la carte de test :</h3>
            <p><strong>Numéro de carte :</strong> 4242 4242 4242 4242</p>
            <p><strong>Date d'expiration (MM/AA) :</strong> N'importe quelle date valide</p>
            <p><strong>CVC :</strong> N'importe quel code</p>
        </div>


    </div>

    <script src="https://js.stripe.com/v3/"></script>
    
    <script>
        var stripe = Stripe('{{ config('services.stripe.key') }}');
        var elements = stripe.elements();
        var cardElement = elements.create('card', {
            style: {
                base: {
                    color: '#32325d',
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#aab7c4'
                    }
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            }
        });
        cardElement.mount('#card-element');


        var form = document.getElementById('payment-form');
        var errorMessageDiv = document.getElementById('error-message');

        form.addEventListener('submit', async function(event) {
            event.preventDefault();

            const {
                token,
                error
            } = await stripe.createToken(cardElement);

            if (error) {
                errorMessageDiv.textContent = error.message;
            } else {
                var formData = new FormData(form);
                formData.append('payment_method_id', token.id);

                form.querySelector('button').disabled = true;

                fetch('/process-payment', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.href = '/reservation-success';
                        } else {
                            errorMessageDiv.textContent = data.message || 'Erreur lors du paiement';
                        }
                    })
                    .catch(error => {
                        errorMessageDiv.textContent = 'Erreur de réseau ou serveur.';
                        console.error('Fetch Error:', error);
                    })
                    .finally(() => {
                        form.querySelector('button').disabled = false;
                    });
            }
        });
        
    </script>
</x-app-layout>
