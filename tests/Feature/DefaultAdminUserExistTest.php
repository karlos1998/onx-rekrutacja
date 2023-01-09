<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DefaultAdminUserExistTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_kontakt_letscode_it_should_be_created_before_by_seeder()
    {
        $email = 'kontakt@letscode.it';

        $response = $this->getJson("/api/emailAvailable?email=$email");

        $response->assertStatus(422);
    }
}
