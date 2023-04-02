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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('chat_id');
            $table->bigInteger('msg_id');
            $table->integer('date')->nullable();
            $table->integer('views')->nullable();
            $table->integer('forwards')->nullable();
            $table->char('title', 255)->nullable();
            $table->text('body')->nullable();
            $table->text('announcement')->nullable();
            $table->char('cover', 255)->nullable();
            $table->char('link', 255)->nullable();
            $table->smallInteger('status', false, true)->nullable();
            $table->timestamps();

            $table->foreign('chat_id', 'fk_news_telegram_chat_id')
                ->references('chat_id')
                ->on('telegram_chats')
                ->onDelete('cascade');
//            $table->foreign('chat_id')->references('chat_id')->on('telegram_chats');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news');
    }
};
