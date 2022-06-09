<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettlements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settlements', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->integer('key');
            $table->unsignedBigInteger('postal_code_id');
            $table->unsignedBigInteger('settlement_type_id');
            $table->unsignedBigInteger('zone_type_id');
            $table->foreign('postal_code_id')->references('id')->on('postal_codes');
            $table->foreign('settlement_type_id')->references('id')->on('settlement_types');
            $table->foreign('zone_type_id')->references('id')->on('zone_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settlements');
    }
}
