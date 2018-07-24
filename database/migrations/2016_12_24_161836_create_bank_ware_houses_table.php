<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankWareHousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_ware_houses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ware_id');
            $table->integer('user_id');
            $table->integer('bank');
            $table->integer('province');
            $table->string('card_number');
            $table->string('card_name');
            $table->integer('check');
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
        Schema::dropIfExists('bank_ware_houses');
    }
}
