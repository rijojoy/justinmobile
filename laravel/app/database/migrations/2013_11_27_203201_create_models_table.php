<?php

use Illuminate\Database\Migrations\Migration;

class CreateModelsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::create('products_models', function ($table){
                $table->increments('id');
                $table->integer('product_id'); // id of the parent product
                $table->string('name', 128); // eg: "2nd Generation"
                $table->string('description', 256); // eg: "iPad with Retina Display
                $table->string('image');
                $table->decimal('base_price', 5, 2);
                $table->binary('properties');
                $table->boolean('available');
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
	    Schema::drop('products_models');
	}

}