<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->date('debut_resa');
            $table->date('fin_resa');
            $table->timestamps();
            $table->softDeletes();

            $table->string('stripe_transaction_id')->nullable()->after('fin_resa');
            $table->decimal('total_amount', 10, 2)->nullable()->after('stripe_transaction_id');
            $table->string('payment_status')->default('pending')->after('total_amount');
            $table->timestamp('payment_date')->nullable()->after('payment_status');
            $table->string('stripe_token')->nullable()->after('payment_date');
            $table->string('stripe_payment_intent_id')->nullable()->after('fin_resa');

            // Définir les clés étrangères
            $table->foreignId('logement_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            // Suppression des champs pour Stripe
            $table->dropColumn('stripe_transaction_id');
            $table->dropColumn('total_amount');
            $table->dropColumn('payment_status');
            $table->dropColumn('payment_date');
            $table->dropColumn('stripe_token');
            $table->dropColumn('stripe_payment_intent_id');

        });
    }
};
