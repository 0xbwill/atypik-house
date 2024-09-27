<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('logements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->string('slug')->unique();
            $table->unsignedInteger('price')->nullable();
            $table->unsignedInteger('capacity')->nullable();
            $table->unsignedInteger('bedrooms')->nullable();
            $table->unsignedInteger('bathrooms')->nullable();
            $table->string('image_url')->nullable();
            $table->string('pet_allowed')->default('no')->nullable();
            $table->string('smoker_allowed')->default('no')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('street')->nullable();
            $table->string('postal_code')->nullable();
            $table->boolean('published')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('logements', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->after('id');
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('cascade')->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logements');

        Schema::table('logements', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
