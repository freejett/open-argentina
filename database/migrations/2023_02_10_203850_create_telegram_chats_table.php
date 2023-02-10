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
        Schema::create('telegram_chats', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('chat_id')->index();
            $table->char('title', 255)->nullable();
            $table->char('username', 255)->nullable();
            $table->text('about')->nullable();
            $table->char('chat_photo', 255)->nullable();
            $table->char('contact', 255)->nullable();
            $table->integer('type_id')->nullable();
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
        Schema::dropIfExists('telegram_chats');
    }
};
