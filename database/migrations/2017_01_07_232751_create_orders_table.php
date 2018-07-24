<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('time_order');
            $table->integer('status');
            $table->integer('customer_id');
            $table->text('note');
            $table->integer('status_pay');
            $table->integer('type_pay');
            $table->integer('received_pay');
            $table->integer('remain_pay');
            $table->string('type_driver');
            $table->string('name_driver');
            $table->string('phone_driver');
            $table->integer('kho_id');
            $table->string('number_license_driver');
            $table->integer('author_id');
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
        Schema::dropIfExists('orders');
    }
}
