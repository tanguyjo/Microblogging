<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfileUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_update_profile()
    {
        // crée un user de test
        $user = User::factory()->create([
            'username' => 'oldname',
            'email' => 'old@example.com',
            'bio' => 'Old bio'
        ]);

        // nouvelle data à envoyer
        $updateData = [
            'username' => 'newname',
            'email' => 'new@example.com',
            'bio' => 'New bio',
        ];

        // fait une requête en tant qu'user connecté
        $response = $this
            ->actingAs($user)
            ->putJson('/api/user', $updateData);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'username' => 'newname',
            'email' => 'new@example.com',
            'bio' => 'New bio',
        ]);

        // vérif aussi en base
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'username' => 'newname',
            'email' => 'new@example.com',
            'bio' => 'New bio',
        ]);
    }
}