<?php

namespace Tests\Feature\Logement;

use App\Models\User;
use App\Models\Logement;
use App\Models\Reservations;
use Spatie\Permission\Models\Role; // Import Spatie's Role model
use Database\Seeders\CategorySeeder; // Import the seeder
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use App\Mail\ReservationConfirmation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Database\Seeders\ReservationsSeeder;
use function Pest\Laravel\get;
use function Pest\Laravel\artisan;

class ReservationTest extends TestCase
{

    /**
     * Test pour vérifier qu'un utilisateur peut créer une réservation et effectuer un paiement.
     *
     * @return void
     */
    public function test_user_can_access_payment_page_after_creating_reservation()
    {

        artisan('db:seed');
        // Seed categories using the CategorySeeder
        $this->seed(CategorySeeder::class);

        // Create a user to act as the 'hôte'
        $host = User::factory()->create();
        $host->assignRole('hôte');

        // Create a logement and assign it to the 'hôte' user
        $logement = Logement::factory()->create(['user_id' => $host->id]);

        // Create a user to act as the customer
        $user = User::factory()->create();
        $user->assignRole('user');

        // Act as the customer
        $this->actingAs($user);

        // Simulate creating a reservation (initially with 'pending' payment status)
        $reservationData = [
            'start_date' => now()->addDays(5)->toDateString(),  // Assuming the method expects 'start_date'
            'end_date' => now()->addDays(10)->toDateString(),   // Assuming the method expects 'end_date'
        ];

        // Submit a POST request to the reservation route (simulate the CTA click)
        $response = $this->post(route('logement.reserver', ['id' => $logement->id]), $reservationData);

        // Assert that the response status is 200 (the payment page/form is displayed)
        $response->assertStatus(200);

        echo $response;
    }

    // public function test_user_can_pay_the_reservation()
    // {
    //     // Seed categories using the CategorySeeder
    //     $this->seed(CategorySeeder::class);
    //     $this->withoutExceptionHandling();

    //     // Create a user to act as the 'hôte'
    //     $host = User::factory()->create();
    //     $host->assignRole('hôte');

    //     // Create a logement and assign it to the 'hôte' user
    //     $logement = Logement::factory()->create(['user_id' => $host->id]);

    //     // Create a user to act as the customer
    //     $user = User::factory()->create();
    //     $user->assignRole('user');

    //     // Act as the customer
    //     $this->actingAs($user);

    //     // Create a reservation manually
    //     $reservation = Reservations::create([
    //         'logement_id' => $logement->id,
    //         'user_id' => $user->id,
    //         'debut_resa' => now()->addDays(5),
    //         'fin_resa' => now()->addDays(10),
    //         'payment_status' => 'pending',
    //     ]);

    //     // Simulate form data to send to the payment process endpoint
    //     $paymentData = [
    //         'logement_id' => $logement->id,
    //         'start_date' => $reservation->debut_resa->toDateString(),
    //         'end_date' => $reservation->fin_resa->toDateString(),
    //         'total_amount' => 1000, // Total amount in cents (e.g., 10.00 €)
    //         'reservation_id' => $reservation->id,
    //         'payment_method_id' => 'pm_card_visa', // A Stripe test payment method
    //     ];

    //     // Mock Stripe PaymentIntent creation to simulate a successful payment
    //     \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
    //     $this->mock(\Stripe\PaymentIntent::class, function ($mock) {
    //         $mock->shouldReceive('create')->andReturn((object)[
    //             'id' => 'pi_123456789',
    //             'status' => 'succeeded',
    //         ]);
    //     });

    //     // Submit a POST request to the payment processing route
    //     $response = $this->post('/process-payment', $paymentData);

    //     // Assert that the payment was processed successfully
    //     $response->assertStatus(200);
    //     $response->assertJson([
    //         'success' => true,
    //         'status' => 'succeeded',
    //     ]);

    //     // Refresh the reservation to check the updated status
    //     $reservation->refresh();

    //     // Assert that the reservation's payment status is updated to 'paid'
    //     $this->assertEquals('paid', $reservation->payment_status);
    //     $this->assertNotNull($reservation->stripe_payment_intent_id);
    // }
}
