<?php

use Illuminate\Database\Migrations\Migration;

class CreateOrdersNotesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::create('orders_notes', function ($table){
                $table->increments('id');
                $table->integer('order_id');
                $table->integer('user_id');
                $table->integer('status_id')->default(0);
                $table->text('body');
                $table->string('byline');
                $table->boolean('send_email');
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
	    Schema::drop('orders_notes');
	}

}