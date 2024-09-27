<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAboutsTable extends Migration
{
    public function up()
    {
        Schema::create('abouts', function (Blueprint $table) {
            $table->id();
            $table->string('section1_title')->default("Séjours insolites en pleine nature")->nullable();
            $table->string('section1_subtitle')->default("Découvrez AtypikHouse")->nullable();
            $table->string('section1_description')->default("AtypikHouse vous propose des hébergements uniques comme des cabanes dans les arbres et des yourtes pour des expériences inoubliables en pleine nature. Vivez un séjour authentique et respectueux de l''environnement, en France.")->nullable();
            $table->string('section1_button_text')->default("Découvrir nos hébergements")->nullable();
            $table->string('section1_button_link')->default("/logements")->nullable();
            $table->string('section1_image')->default("images/logement_example_1.jpg")->nullable();
        
            $table->string('section2_title')->default("Voyagez autrement")->nullable();
            $table->string('section2_subtitle')->default("Explorez AtypikHouse")->nullable();
            $table->string('section2_description')->default("Reconnectez-vous avec la nature grâce à nos cabanes perchées et yourtes. AtypikHouse, c''est l''alliance de l''écologie et du confort pour un tourisme durable en France.")->nullable();
            $table->string('section2_button_text')->default("Nous contacter")->nullable();
            $table->string('section2_button_link')->default("/contact")->nullable();
            $table->string('section2_image')->default("images/logement_example.jpg")->nullable();
        
            $table->timestamps();
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('abouts');
    }
}
