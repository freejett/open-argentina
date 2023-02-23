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
        Schema::create('raw_appartments_data', function (Blueprint $table) {
            $table->bigInteger('chat_id')->index();
            $table->bigInteger('msg_id')->index();
            $table->text('msg')->nullable();
            $table->char('is_appartment')->nullable();
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
        Schema::dropIfExists('raw_appartments_data');
    }
};
