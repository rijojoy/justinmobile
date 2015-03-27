<?php

class PropertiesController extends \BaseController {

        public function __construct() {
            $this->beforeFilter('auth');
        }
    
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($product_id, $model_id)
	{
            $product = Product::findOrFail($product_id);
            $model = ProductModel::findOrFail($model_id);
	    return View::make('admin.products.models.properties.create', array('product' => $product, 'model' => $model));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($product_id, $model_id)
	{
            $product = Product::findOrFail($product_id);
            $model = ProductModel::findOrFail($model_id);
            
            $input = Input::all();
            
            $rules = array(
                'name' => 'required|max:128',
                'title' => 'required|max:128',
                'type' => 'required|in:single,multi',
                'order' => 'required|numeric'
            );
            
            $validator = Validator::make($input, $rules);
            
            if ($validator->fails()) {
                return Redirect::to("/admin/products/{$product->id}/models/{$model->id}/properties/create")->withErrors($validator)->withInput();
            }
            
            $property = new ProductModelProperty;
            $property->model_id = $model->id;
            $property->name = $input['name'];
            $property->title = $input['title'];
            $property->help_text = $input['help_text'];
			$property->explanation_name = $input['explanation_name'];
			$property->explanation_description = $input['explanation_description'];
            $property->type = $input['type'];
            $property->required = isset($input['required']) ? 1 : 0;
            $property->order = $input['order'];
            $property->save();
            
            // Log entry
            $log = new \ActionLog;
            $log->user_id = \Sentry::getUser()->id;
            $log->item_id = $property->id;
            $log->item_type = 'property';
            $log->title = 'Created Property';
            $log->data = json_encode($input);
            $log->save();
            
            return Redirect::to("/admin/products/{$product->id}/models/{$model->id}/properties/{$property->id}")->with('message', 'Property created');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($product_id, $model_id, $property_id)
	{
            $product = Product::findOrFail($product_id);
            $model = ProductModel::findOrFail($model_id);
            $property = ProductModelProperty::findOrFail($property_id);
            $options = $property->options;
            return View::make('admin.products.models.properties.show', array('product' => $product, 'model' => $model, 'property' => $property, 'options' => $options));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($product_id, $model_id, $property_id)
	{
            $product = Product::findOrFail($product_id);
            $model = ProductModel::findOrFail($model_id);
            $property = ProductModelProperty::findOrFail($property_id);
            return View::make('admin.products.models.properties.edit', array('product' => $product, 'model' => $model, 'property' => $property));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($product_id, $model_id, $property_id)
	{
            $product = Product::findOrFail($product_id);
            $model = ProductModel::findOrFail($model_id);
            $property = ProductModelProperty::findOrFail($property_id);
            
            $input = Input::all();

            $rules = array(
                'name' => 'required|max:128',
                'title' => 'required|max:128',
                'type' => 'required|in:single,multi',
                'order' => 'required|numeric'
            );

            $validator = Validator::make($input, $rules);

            if ($validator->fails()) {
                return Redirect::to("admin/products/{$product_id}/models/{$model_id}/properties/{$property_id}/edit")->withErrors($validator)->withInput();
            }
            
            $property->name = $input['name'];
            $property->title = $input['title'];
            $property->help_text = $input['help_text'];
			$property->explanation_name = $input['explanation_name'];
			$property->explanation_description = $input['explanation_description'];
            $property->order = $input['order'];
            $property->type = $input['type'];
            $property->required = isset($input['required']) ? 1 : 0;
            $property->save();
            
            // Log entry
            $log = new \ActionLog;
            $log->user_id = \Sentry::getUser()->id;
            $log->item_id = $property->id;
            $log->item_type = 'property';
            $log->title = 'Edited Property';
            $log->data = json_encode($input);
            $log->save();
            
            return Redirect::to("admin/products/{$product_id}/models/{$model_id}/properties/{$property_id}")->with('message', 'Property updated');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($product_id, $model_id, $property_id)
	{
            $product = Product::findOrFail($product_id);
            $model = ProductModel::findOrFail($model_id);
            $property = ProductModelProperty::findOrFail($property_id);
            $property->delete();
            
            // Log entry
            $log = new \ActionLog;
            $log->user_id = \Sentry::getUser()->id;
            $log->item_id = $property->id;
            $log->item_type = 'property';
            $log->title = 'Deleted Property';
            $log->data = json_encode($property->toArray());
            $log->save();
            
            return Redirect::to("admin/products/{$product_id}/models/{$model_id}")->with('message', 'Property deleted');
	}

}