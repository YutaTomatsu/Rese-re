<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservesCourcesTable extends Migration
{
    public function up()
    {
        Schema::create('reserves_cources', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reserve_id');
            $table->foreign('reserve_id')->references('id')->on('reserves')->onDelete('cascade');
            $table->string('cource');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reserves_cources');
    }
}
