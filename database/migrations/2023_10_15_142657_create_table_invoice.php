<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableInvoice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice', function (Blueprint $table) {
            $table->bigIncrements('invoice_id');
            $table->string('invoice_no', 255)->nullable(false);
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id')->references('customer_id')->on('customer')->onUpdate('cascade')->onDelete('restrict');
            $table->string('insurance_company', 255)->nullable();
            $table->string('vehicle_no', 50)->nullable(false);
            $table->string('model', 150)->nullable();
            $table->integer('vat_number')->nullable();
            $table->double('with_out_tax_amount', 10, 2)->default('0.00');
            $table->double('cash_discount', 10, 2)->default('0.00');
            $table->double('nbt', 10, 2)->default('0.00');
            $table->double('vat', 10, 2)->default('0.00');
            $table->double('net_amount', 10, 2)->default('0.00');
            $table->double('paid_amount', 10, 2)->default('0.00');
            $table->double('balance', 10, 2)->default('0.00');
            $table->date('invoice_date')->nullable(false);
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
        Schema::dropIfExists('invoice');
    }
}
