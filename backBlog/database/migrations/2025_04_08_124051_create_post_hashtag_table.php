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
        Schema::create('post_hashtag', function (Blueprint $table) {
            $table->id();

            $table->foreignId('post_id')->constrained('posts')->onDelete('cascade');
            $table->foreignId('hashtag_id')->constrained('hashtags')->onDelete('cascade');

            $table->timestamps();

            $table->unique(['post_id', 'hashtag_id']); // Empêche les doublons
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_hashtag');
    }
};
