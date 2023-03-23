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
            $table->integer('date');
            $table->char('title', 255)->nullable();
            $table->text('body')->nullable();
            $table->text('announcement')->nullable();
            $table->char('cover', 255)->nullable();
            $table->char('link', 255)->nullable();
            $table->smallInteger('status', false, true)->nullable();
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
        Schema::dropIfExists('news');
    }
};
