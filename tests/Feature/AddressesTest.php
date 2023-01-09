<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Address;

class AddAddressTest extends TestCase
{

    use DatabaseTransactions;
    protected $user;
    
    public function setUp():void
    {
        parent::setUp();

        $user = User::factory()->create();
        $user->attachRole('user');
        $this->user = $user;
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_add_address_and_login()
    {

        $response = $this->actingAs($this->user)->postJson('/api/address', [
            "uuid" => "f35cf7075ceb61041b8b5b76af74c6ca",
            "state" => "mazowieckie",
            "county" => "wyszkowski",
            "municipality" => "Długosiodło",
            "city" => "Długosiodło",
            "cityDistricted" => "Długosiodło",
            "zip" => "07-210",
            "street" => "Ostrołęcka",
            "street1" => "Ostrołęcka",
            "streetPrefix" => "ul.",
            "streetTeryt" => "Ostrołęcka",
            "houseNumber" => "12",
            "location" => [
                "latitude" => 52.761491,
                "longitude" => 21.59981,
                "xyClass" => 240,
            ],
            "order" => 41,
            "name" => "Długosiodło, Ostrołęcka 12"
        ]);

        $response->assertStatus(201)->assertJsonPath('data.id', fn($id) => $id > 0);

        return $response['data']['id'];
    }

    /**
     * @depends test_add_address_and_login
     **/
    public function test_delete_addres($id)
    {
        $address = Address::factory()->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user)->delete("/api/address/{$address->id}");
        $response->assertStatus(204);
    }

    /**
     * @depends test_delete_addres
     **/
    public function test_pach_addres($id)
    {
        $address = Address::factory()->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user)->call("PATCH", "/api/address/{$address->id}", array('friendly_name' => 'test'));
        $response->assertStatus(200);
    }

    /**
     * @depends test_pach_addres
     **/
    public function test_delete_many($id)
    {
        $addresses = [
            Address::factory()->create(['user_id' => $this->user->id]),
            Address::factory()->create(['user_id' => $this->user->id]),
            Address::factory()->create(['user_id' => $this->user->id]),
            Address::factory()->create(['user_id' => $this->user->id]),
            Address::factory()->create(['user_id' => $this->user->id]),
            Address::factory()->create(['user_id' => $this->user->id]),
            Address::factory()->create(['user_id' => $this->user->id]),
            Address::factory()->create(['user_id' => $this->user->id])
        ];

        $response = $this->actingAs($this->user)->delete("/api/addresses", array(
            'ids' => array_map(fn($d) => $d->id, $addresses)
        ));
        $response->assertStatus(204);
    }
}
