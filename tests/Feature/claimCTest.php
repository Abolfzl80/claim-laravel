<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Claim;

class claimCTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_register_new_user_and_get_all_claims(): void
    {
        $user = User::factory()->make();

        $reg = $this->postJson('/api/register' , [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'password', 
            'password_confirmation' => 'password', 
        ]);

        $t = $reg->json('token');

        $c = $this->withHeaders([
            'Authorization' => 'Bearer ' . $t,  
        ])->get('/api/claim');
        $c->assertStatus(200);
    }

    public function test_register_new_user_and_create_claim()
    {
        $u = User::factory()->make();
        $c = Claim::factory()->make();

        $reg = $this->postJson('/api/register' , [
            'name' => $u->name,
            'email' => $u->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $t = $reg->json('token');

        $res = $this->withHeaders([
            'Authorization' => 'Bearer ' . $t,  
        ])->postJson('/api/claim/create' , [
            'title' => $c->title,
            'description' => $c->description,
        ]);
        $res->assertStatus(201);

    }   
}
