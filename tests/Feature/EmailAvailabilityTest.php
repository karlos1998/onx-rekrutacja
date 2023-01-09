<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;

class EmailAvailabilityTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_the_email_is_available()
    {
        $email = fake()->unique()->safeEmail();

        $response = $this->get("/api/emailAvailable?email=$email");

        $response->assertStatus(200);
    }

    public function test_this_mail_is_used()
    {
        $user = User::factory()->create();
        $user->attachRole('user');

        $email = $user->email;

        $response = $this->getJson("/api/emailAvailable?email=$email");

        $response->assertStatus(422);
    }

}
