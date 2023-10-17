<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('p_id');
            $table->unsignedBigInteger('cat_id')->nullable();
            $table->foreign('cat_id')->on('category')->references('cat_id')->onUpdate('cascade')->onDelete('restrict');
            $table->string('item', 255)->nullable(false);
            $table->string('description', 3000)->nullable();
            $table->string('unit', 255)->nullable();
            $table->integer('line_no')->nullable();
            $table->string('department', 255)->nullable();
            $table->double('cost')->default('0.00');
            $table->double('selling_price')->default('0.00');
            $table->integer('rol')->nullable();
            $table->integer('capacity')->nullable();
            $table->integer('open_stock')->nullable();
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
        Schema::dropIfExists('products');
    }
}
