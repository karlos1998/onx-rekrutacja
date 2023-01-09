<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
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
            "location_latitude" => 52.761491,
            "location_longitude" => 21.59981,
            "location_xyClass" => 240,
            "name" => "Długosiodło, Ostrołęcka 12"
        ];
    }
}
