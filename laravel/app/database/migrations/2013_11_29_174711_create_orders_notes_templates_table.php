<?php

use Illuminate\Database\Migrations\Migration;

class CreateOrdersNotesTemplatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::create('orders_notes_templates', function ($table) {
                $table->increments('id');
                $table->string('name');
                $table->integer('status_id');
                $table->text('body');
                $table->boolean('send_email');
            });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	    Schema::drop('orders_notes_templates');
	}

}