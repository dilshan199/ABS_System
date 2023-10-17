<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableQuotationItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotation_item', function (Blueprint $table) {
            $table->bigIncrements('quotation_rol_id');
            $table->unsignedBigInteger('quotation_id')->nullable();
            $table->foreign('quotation_id')->references('quotation_id')->on('quotation')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('cat_id')->nullable();
            $table->foreign('cat_id')->references('cat_id')->on('category')->onUpdate('cascade')->onDelete('restrict');
            $table->unsignedBigInteger('p_id')->nullable();
            $table->foreign('p_id')->references('p_id')->on('products')->onUpdate('cascade')->onDelete('restrict');
            $table->string('supp_type', 150)->nullable(false);
            $table->double('hours', 10, 2)->default('0.00');
            $table->double('amount', 10, 2)->default('0.00');
            $table->double('amount2', 10, 2)->default('0.00');
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
        Schema::dropIfExists('quotation_item');
    }
}
