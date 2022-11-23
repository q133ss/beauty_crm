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
        Schema::create('user_salon', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('salon_id');
            $table->unsignedBigInteger('post_id')->nullable()->comment('Должность в салоне');
            $table->foreign('post_id')->references('id')->on('stuff_posts');
            $table->boolean('is_client')->default(true);
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
        Schema::dropIfExists('user_salon');
    }
};
