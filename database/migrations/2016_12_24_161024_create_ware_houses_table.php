<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWareHousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ware_houses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('name_company')->nullable();
            $table->string('address')->nullable();
            $table->integer('province')->nullable();
            $table->string('mst')->nullable();
            $table->string('ndd')->nullable();
            $table->integer('stk')->nullable();
            $table->integer('level')->default(1);
            $table->string('image_kho')->nullable();
            $table->string('time_active')->nullable();
            $table->integer('confirm_kho')->default(0);
            $table->integer('quangcao')->default(0);
            $table->integer('user_test')->nullable();
            $table->string('date_end_test')->nullable();
            $table->integer('category_warehouse_id')->nullable();
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
        Schema::dropIfExists('ware_houses');
    }
}
