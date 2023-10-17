<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment', function (Blueprint $table) {
            $table->bigIncrements('payment_id');
            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->foreign('invoice_id')->references('invoice_id')->on('invoice')->onUpdate('cascade')->onDelete('restrict');
            $table->string('account', 150)->nullable(false);
            $table->string('payment_type', 150)->nullable(false);
            $table->integer('transaction_no')->nullable();
            $table->double('amount', 10, 2)->default('0.00');
            $table->date('payment_date')->nullable(false);
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
        Schema::dropIfExists('payment');
    }
}
