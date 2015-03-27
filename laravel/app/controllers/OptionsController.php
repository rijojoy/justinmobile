<?php

class OptionsController extends \BaseController {

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
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($product_id, $model_id, $property_id)
	{
            $product = Product::findOrFail($product_id);
            $model = ProductModel::findOrFail($model_id);
            $property = ProductModelProperty::findOrFail($property_id);
	    return View::make('admin.products.models.properties.options.create', array('product' => $product, 'model' => $model, 'property' => $property));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($product_id, $model_id, $property_id)
	{
            $product = Product::findOrFail($product_id);
            $model = ProductModel::findOrFail($model_id);
            $property = ProductModelProperty::findOrFail($property_id);
            
            $input = Input::all();
            
            $rules = array(
                'name' => 'required|max:128',
                'modifier_amount' => 'required|numeric',
                'modifier_type' => 'in:add_percentage,deduct_percentage,add_amount,deduct_amount',
                'order_pos' => 'numeric'
            );
            
            $validator = Validator::make($input, $rules);
            
            if ($validator->fails()) {
                return Redirect::to("admin/products/{$product_id}/models/{$model_id}/properties/{$property_id}/options/create")->withErrors($validator)->withInput();
            }
            
            $option = new ProductModelPropertyOption;
            $option->property_id = $property_id;
            $option->name = $input['name'];
            $option->modifier_amount = $input['modifier_amount'];
            $option->modifier_type = $input['modifier_type'];
            $option->explanation = isset($input['explanation']) ? 1 : 0;
            $option->order_pos = $input['order_pos'];
            $option->save();
            
            // Log entry
            $log = new \ActionLog;
            $log->user_id = \Sentry::getUser()->id;
            $log->item_id = $option->id;
            $log->item_type = 'option';
            $log->title = 'Created Option';
            $log->data = json_encode($input);
            $log->save();
            
            return Redirect::to("admin/products/{$product_id}/models/{$model_id}/properties/{$property_id}")->with('message', 'New option has been created');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($product_id, $model_id, $property_id, $option_id)
	{
            
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($product_id, $model_id, $property_id, $option_id)
	{
            $product = Product::findOrFail($product_id);
            $model = ProductModel::findOrFail($model_id);
            $property = ProductModelProperty::findOrFail($property_id);
            $option = ProductModelPropertyOption::findOrFail($option_id);
	    return View::make('admin.products.models.properties.options.edit', array('product' => $product, 'model' => $model, 'property' => $property, 'option' => $option));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($product_id, $model_id, $property_id, $option_id)
	{
            $product = Product::findOrFail($product_id);
            $model = ProductModel::findOrFail($model_id);
            $property = ProductModelProperty::findOrFail($property_id);
            $option = ProductModelPropertyOption::findOrFail($option_id);
            
            $input = Input::all();

            $rules = array(
                'name' => 'required|max:128',
                'modifier_amount' => 'required|numeric',
                'modifier_type' => 'in:add_percentage,deduct_percentage,add_amount,deduct_amount',
                'order_pos' => 'numeric'
            );

            $validator = Validator::make($input, $rules);

            if ($validator->fails()) {
                return Redirect::to("admin/products/{$product_id}/models/{$model_id}/properties/{$property_id}/options/{$option_id}/edit")->withErrors($validator)->withInput();
            }
            
            $option->name = $input['name'];
            $option->modifier_type = $input['modifier_type'];
            $option->modifier_amount = $input['modifier_amount'];
            $option->explanation = isset($input['explanation']) ? 1 : 0;
            $option->order_pos = $input['order_pos'];
            $option->save();
            
            // Log entry
            $log = new \ActionLog;
            $log->user_id = \Sentry::getUser()->id;
            $log->item_id = $option->id;
            $log->item_type = 'option';
            $log->title = 'Created Option';
            $log->data = json_encode($input);
            $log->save();
            
            return Redirect::to("admin/products/{$product_id}/models/{$model_id}/properties/{$property_id}")->with('message', 'Option has been updated');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($product_id, $model_id, $property_id, $option_id)
	{
            $product = Product::findOrFail($product_id);
            $model = ProductModel::findOrFail($model_id);
            $property = ProductModelProperty::findOrFail($property_id);
            $option = ProductModelPropertyOption::findOrFail($option_id);
            $option->delete();
            
            // Log entry
            $log = new \ActionLog;
            $log->user_id = \Sentry::getUser()->id;
            $log->item_id = $option->id;
            $log->item_type = 'option';
            $log->title = 'Deleted Option';
            $log->data = json_encode($option->toArray());
            $log->save();
            
            return Redirect::to("admin/products/{$product_id}/models/{$model_id}/properties/{$property_id}")->with('message', 'Option deleted');
	}

}