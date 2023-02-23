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
        Schema::create('chat_settings', function (Blueprint $table) {
            $table->bigInteger('chat_id')->index();
            $table->bigInteger('current_msg_id')->nullable();
            $table->integer('per_page')->nullable();
            $table->bigInteger('last_chat_msg_id')->nullable();
            $table->json('chat_info');
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
        Schema::dropIfExists('chat_settings');
    }
};
