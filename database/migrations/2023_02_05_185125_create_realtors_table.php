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
        Schema::create('realtors', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('chat_id')->index();
            $table->char('name', 255)->nullable();
            $table->char('telegram', 255)->nullable();
            $table->char('whatsapp', 255)->nullable();
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
        Schema::dropIfExists('realtors');
    }
};
