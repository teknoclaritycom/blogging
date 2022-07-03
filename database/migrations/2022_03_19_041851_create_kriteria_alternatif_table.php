<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKriteriaAlternatifTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kriteria_alternatif', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alternatif_id')->references('id')->on('alternatifs');
            $table->foreignId('kriteria_id')->references('id')->on('kriteria');
            $table->float('score');
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
        Schema::dropIfExists('kriteria_alternatif');
    }
}
