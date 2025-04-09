<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

class UserApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_get_user_profile()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->getJson('/api/user');

        $response->assertStatus(200)
            ->assertJson([
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email
            ]);
    }

    /** @test */
    public function it_can_update_user_profile()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->putJson('/api/user', [
            'username' => 'Updated Name',
            'email' => 'updated@example.com'
        ]);

        $response->assertStatus(200);
        $this->assertEquals('Updated Name', $user->fresh()->username);
        $this->assertEquals('updated@example.com', $user->fresh()->email);
    }
}