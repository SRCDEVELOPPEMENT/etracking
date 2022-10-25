<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLivraisonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('livraisons', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->lenght(255);
            $table->string('state')->lenght(20);
            $table->date('delivery_date');
            $table->date('really_delivery_date')->nullable();
            $table->integer('tonnage')->lenght(255)->nullable();
            $table->float('distance')->nullable();
            $table->float('delivery_amount');
            $table->unsignedBigInteger('vehicule_id')->nullable();
            $table->foreign('vehicule_id')->references('id')->on('vehicules');
            $table->unsignedBigInteger('recipe_id')->nullable();
            $table->foreign('recipe_id')->references('id')->on('recipes');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('nom_client')->lenght(255);
            $table->bigInteger('phone_client');
            $table->string('itinerary')->lenght(255);
            $table->float('amount_paye');
            $table->string('observation')->lenght(255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('livraisons');
    }
}
