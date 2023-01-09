<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;

use Illuminate\Support\Str;

class RegisterDefaultUserTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_user()
    {

        $response = $this->postJson('/api/user', [
            'email' => fake()->unique()->safeEmail(), 
            'password'=> Str::random(10), 
            'firstname' => fake()->firstName(),
            'lastname' => fake()->lastName()
        ]);

        $response->assertStatus(200);
    }
}
