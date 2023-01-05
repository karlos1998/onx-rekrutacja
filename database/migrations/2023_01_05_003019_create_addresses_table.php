<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string("city")->nullable();
            $table->string("cityDistricted")->nullable();
            $table->string("county")->nullable();
            $table->string("houseNumber")->nullable();

            $table->double("location_latitude")->nullable();
            $table->double("location_longitude")->nullable();
            $table->integer("location_xyClass")->nullable();

            $table->string("municipality")->nullable();
            $table->string("name")->nullable();
            $table->string("state")->nullable();
            $table->string("street")->nullable();
            $table->string("street1")->nullable();
            $table->string("streetPrefix")->nullable();
            $table->string("streetTeryt")->nullable();
            $table->string("uuid")->nullable();
            $table->string("zip")->nullable();


            /**
             * Linking the address with the user
             */
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
};
