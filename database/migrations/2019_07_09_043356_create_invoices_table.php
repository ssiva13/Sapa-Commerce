<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->integer('order_id');
            $table->integer('user_id')->nullable();
            $table->double('total', 2);
            $table->boolean('paid')->nullable();
            $table->boolean('delivered')->nullable();
            $table->string('payment_method')->nullable();
            $table->integer('payment_id')->nullable();
            $table->integer('mpesa_id')->nullable();
            $table->integer('paypal_id')->nullable();
            // $table->foreign('order_id')->references('id')->on('orders')
            //     ->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('invoices');
    }
}
