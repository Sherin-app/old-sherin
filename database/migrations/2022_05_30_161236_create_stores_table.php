<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('activity_id');
            $table->string('logo');
            $table->string('name');
            $table->string('phone');
            $table->string('contact');
            $table->text('address');
            $table->integer('base');
            $table->integer('base_profit');
            $table->integer('coeff');
            $table->integer('tva');
            $table->tinyInteger('status')->default(1)->comment="0:innactie,1:active";
            $table->text('invoice_message');
            $table->tinyInteger('allow_camp')->default(0);
            $table->string('sender_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stores');
    }
}
