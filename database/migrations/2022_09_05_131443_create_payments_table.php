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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            // "order_id", not "customer_id"
            $table->unsignedBigInteger('order_id');
            $table->string('gateway');
            $table->unsignedBigInteger('gateway_payment_id');
            $table->string('status');
            $table->integer('amount');
            $table->integer('amount_paid');
            $table->text('input_data');
            $table->timestamps();

            $table->index(['gateway', 'gateway_payment_id']);

            // let's postpone the foreign key for now
            // $table->foreign('order_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
