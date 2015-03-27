<?php

use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::create('products', function ($table){
               $table->increments('id');
               $table->string('name', 128); // eg: ipad
               $table->string('slug', 64); // eg: ipad, used in the url
               $table->string('logo');
               $table->boolean('default');
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
	    Schema::drop('products');
	}

}