<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableQuotation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotation', function (Blueprint $table) {
            $table->bigIncrements('quotation_id');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id')->references('customer_id')->on('customer')->onUpdate('cascade')->onDelete('restrict');
            $table->string('insurance_company', 255)->nullable();
            $table->string('vehicle_no', 50)->nullable(false);
            $table->integer('year')->nullable();
            $table->string('chasis_no', 255)->nullable();
            $table->string('color', 50)->nullable();
            $table->double('meter_reading', 10, 4)->nullable();
            $table->string('model', 150)->nullable();
            $table->string('engine_no', 255)->nullable();
            $table->string('remarks', 3000)->nullable();
            $table->double('quo_amount', 10, 2)->default('0.00');
            $table->date('quotation_date')->nullable(false);
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
        Schema::dropIfExists('quotation');
    }
}
