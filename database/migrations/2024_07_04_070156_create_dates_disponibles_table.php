<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('dates_disponibles', function (Blueprint $table) {
            $table->id();
            $table->date('debut_dispo');
            $table->date('fin_dispo');
            $table->timestamps();

            // Définir les clés étrangères
            $table->foreignId('logement_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dates_disponibles');
    }
};
