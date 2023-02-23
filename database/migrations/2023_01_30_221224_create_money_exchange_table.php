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
        Schema::create('money_exchanges', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('chat_id')->index();
            $table->bigInteger('msg_id')->index();
            $table->bigInteger('exchange_direction_id')->nullable();
            $table->bigInteger('date')->nullable();
            $table->bigInteger('rate')->nullable();
            $table->text('msg')->nullable();
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
        Schema::dropIfExists('money_exchanges');
    }
};
