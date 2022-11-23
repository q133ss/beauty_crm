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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('service_name');
            $table->double('price');
            $table->date('date');
            $table->time('time');
            $table->foreignId('order_status_id');
            $table->unsignedBigInteger('client_id');
            $table->foreignId('salon_id');
            $table->unsignedBigInteger('master_id');
            $table->foreignId('service_id');
            $table->time('work_time');
            $table->string('prepayment_percentage')->nullable();
            $table->foreign('client_id')->references('id')->on('users');
            $table->foreign('master_id')->references('id')->on('users');
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
        Schema::dropIfExists('orders');
    }
};
