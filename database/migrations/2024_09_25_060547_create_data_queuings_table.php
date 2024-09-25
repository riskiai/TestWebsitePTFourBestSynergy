<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataQueuingsTable extends Migration
{
    public function up()
    {
        Schema::create('data_queuing', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('no_polisi', 50);
            $table->enum('jenis_antrian', ['GR', 'BP']);
            $table->enum('status', ['waiting', 'called'])->default('waiting');
            $table->timestamps();

            // Foreign key untuk user
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('data_queuing');
    }
}
