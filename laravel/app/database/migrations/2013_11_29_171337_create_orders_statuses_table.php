<?php

use Illuminate\Database\Migrations\Migration;

class CreateOrdersStatusesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::create('orders_statuses', function ($table){
                $table->increments('id');
                $table->string('name');
                $table->string('class');
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
	    Schema::drop('orders_statuses');
	}

}