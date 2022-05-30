<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('store_id');
            $table->integer('user_id');
            $table->integer('employ_id');
            $table->integer('customer_id');
            $table->tinyInteger('for_sexe')->commet='1:Home;2:Femme;3:Mixed';
            $table->text('description')->comment='0:H;1:F';
            $table->dateTime('invoice_date');
            $table->decimal('total');	
            $table->decimal('total_ht');
            $table->decimal('tva');
            $table->decimal('paid_amount');
            $table->tinyInteger('payment_method')->comment='1:Espece;2:check;3:credit card';
            $table->integer('points');
            $table->tinyInteger('status')->comment='0:pending;4:cancelled';
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
