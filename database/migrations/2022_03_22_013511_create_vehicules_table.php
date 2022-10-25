<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateVehiculesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicules', function (Blueprint $table) {
            $table->id();
            $table->string('Immatriculation')->unique()->lenght(50);
            $table->integer('tonnage')->lenght(100);
            $table->string('ModelVehicule')->lenght(100);
            $table->enum('StatutVehicule', ['EnPanne', 'EnFonctionnement']);
            $table->string('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicules');
    }
}
