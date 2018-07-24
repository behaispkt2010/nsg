<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('slug');
            $table->string('code');
            $table->integer('gram')->default(0);
            $table->integer('price_in')->default(0);
            $table->integer('price_out')->default(0);
            $table->integer('min_gram')->default(0);
            $table->integer('inventory')->default(0);
            $table->integer('inventory_num')->default(0);
            $table->integer('category')->default(0);
            $table->integer('kho')->default(0);
            $table->longText('content');
            $table->text('title_seo');
            $table->text('description');
            $table->string('image')->default('/images/default-img-articles.jpg');
            $table->integer('author_id');
            $table->integer('status')->default(1);
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
