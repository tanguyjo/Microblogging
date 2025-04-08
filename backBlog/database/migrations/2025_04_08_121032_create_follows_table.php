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
        Schema::create('follows', function (Blueprint $table) {
            $table->bigIncrements('id');

            // L'utilisateur qui suit
            $table->foreignId('follower_id')
                ->constrained('users')
                ->onDelete('cascade');

            // L'utilisateur suivi
            $table->foreignId('followed_id')
                ->constrained('users')
                ->onDelete('cascade');

                $table->timestamps();

            // Empêche les doublons (un utilisateur ne peut pas suivre deux fois la même personne)
            $table->unique(['follower_id', 'followed_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('follows');
    }
};
