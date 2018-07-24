<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductUpdatePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_update_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->integer('price_in')->default(0);
            $table->integer('price_out')->default(0);
            $table->integer('number');
            $table->string('supplier');
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
        Schema::dropIfExists('product_update_prices');
    }
}
