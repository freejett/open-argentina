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
        Schema::create('apartments_data', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('chat_id')->index();
            $table->bigInteger('msg_id')->index();
            $table->char('title', 255)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('full_address', 500)->nullable();
            $table->float('lat', 10, 6)->nullable();
            $table->float('lng', 10, 6)->nullable();
            $table->char('status', 1)->nullable();
            $table->decimal('price')->nullable();
            $table->string('full_price', 500)->nullable();
            $table->char('pets_allowed', 1)->nullable();
            $table->char('kids_allowed', 1)->nullable();
            $table->text('advantages')->nullable();
            $table->char('type', 1)->nullable();
            $table->integer('number_of_rooms')->nullable();
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
        Schema::dropIfExists('apartments_data');
    }
};
