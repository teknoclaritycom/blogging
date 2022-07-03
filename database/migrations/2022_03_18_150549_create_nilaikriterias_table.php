<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNilaikriteriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilaikriterias', function (Blueprint $table) {
            $table->id();
            $table->integer('idpertama');
            $table->double('value',8,3);
            $table->integer('idkedua');
            $table->foreignId('iddms')->references('id')->on('decisioners')->onDelete('cascade');
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
        Schema::dropIfExists('nilaikriterias');
    }
}
