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
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');

            // Clé étrangère vers users
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->string('title');
            $table->text('content');

            // Enum PostgreSQL avec valeurs : draft, published
            $table->enum('status', ['draft', 'published'])->default('draft');

            // Enum visibilité : public, private, followers
            $table->enum('visibility', ['public', 'private', 'followers'])->default('public');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
