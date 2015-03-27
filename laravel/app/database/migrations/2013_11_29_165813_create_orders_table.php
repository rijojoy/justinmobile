<?php

use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::create('orders', function ($table) {
                $table->increments('id');
                $table->integer('product_id');
                $table->text('product_cache');
                $table->integer('model_id');
                $table->text('model_cache');
                $table->text('properties_cache');
                $table->text('options_input');
                $table->text('options_cache');
                $table->text('order_info');
                $table->text('personal_info');
                $table->bigInteger('imei');
                $table->integer('latest_note_id');
                $table->integer('status_id')->default('1');
		$table->text('hashed_id');
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
	    Schema::drop('orders');
	}

}
