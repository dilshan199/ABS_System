<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSupplimentryQuotationItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplimentry_quotation_item', function (Blueprint $table) {
            $table->bigIncrements('supplimentry_quotation_rol_id');
            $table->unsignedBigInteger('supplimentry_quotation_id')->nullable();
            $table->foreign('supplimentry_quotation_id')->references('supplimentry_quotation_id')->on('supplimentry_quotation')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('supplimentry_quotation_item');
    }
}
