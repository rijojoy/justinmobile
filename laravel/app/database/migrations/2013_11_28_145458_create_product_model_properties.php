<?php

use Illuminate\Database\Migrations\Migration;

class CreateProductModelProperties extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::create('products_models_properties', function ($table) {
                $table->increments('id'); 
                $table->integer('model_id');
                $table->string('name');
                $table->string('title');
                $table->text('help_text');
                $table->enum('type', array('single', 'multi'));
                $table->boolean('required');
                $table->integer('order');
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
	    Schema::drop('products_models_properties');
	}

}