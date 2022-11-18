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
            $table->enum('status', ['wait', 'done', 'cancel'])->comment('Ожидает оплату, оплачен, не оплачен');
            $table->foreignId('client_id');
            $table->foreignId('salon_id');
            $table->foreignId('service_id');
            $table->boolean('prepayment');
            $table->string('prepayment_percentage')->nullable();
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
