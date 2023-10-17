<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableInvoiceItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_item', function (Blueprint $table) {
            $table->bigIncrements('invoice_rol_id');
            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->foreign('invoice_id')->references('invoice_id')->on('invoice')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('cat_id')->nullable();
            $table->foreign('cat_id')->references('cat_id')->on('category')->onUpdate('cascade')->onDelete('restrict');
            $table->unsignedBigInteger('p_id')->nullable();
            $table->foreign('p_id')->references('p_id')->on('products')->onUpdate('cascade')->onDelete('restrict');
            $table->string('item_description', 3000)->nullable();
            $table->integer('qty')->default(0);
            $table->double('cost', 10, 2)->default('0.00');
            $table->double('rate', 10, 2)->default('0.00');
            $table->string('dep', 255)->nullable();
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
        Schema::dropIfExists('invoice_item');
    }
}
