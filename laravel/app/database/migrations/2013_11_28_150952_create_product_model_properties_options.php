<?php

use Illuminate\Database\Migrations\Migration;

class CreateProductModelPropertiesOptions extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::create('products_models_properties_options', function ($table){
                $table->increments('id');
                $table->integer('property_id');
                $table->string('name', 128);
                $table->enum('modifier_type', array('add_percentage', 'deduct_percentage', 'add_amount', 'deduct_amount'));
                $table->boolean('explanation');
                $table->decimal('modifier_amount', 5, 2);
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
	    Schema::drop('products_models_properties_options');
	}

}