<?php

use Illuminate\Database\Migrations\Migration;

class CreateLogsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::create('logs', function ($table){
                $table->increments('id');
                $table->integer('user_id');
                $table->integer('item_id');
                $table->string('item_type');
                $table->string('title');
                $table->string('summary');
                $table->string('data');
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
	    Schema::drop('logs');
	}

}