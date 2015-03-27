<?php

class ModelsController extends \BaseController {

        public function __construct() {
            $this->beforeFilter('auth');
        }
    
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($product_id)
	{
	    return Redirect::to("admin/products/{$product_id}");
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($product_id)
	{
	    $product = Product::findOrFail($product_id);
            return View::make('admin.products.models.create', array('product' => $product));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($product_id)
	{
            $product = Product::findOrFail($product_id);
            $input = Input::all();

            $rules = array(
                'name' => 'required|max:128',
                'description' => 'max:256',
                'image' => 'required|mimes:jpeg,bmp,png,gif',
                'base_price' => 'required|numeric',
                'min_price' => 'required|numeric'
            );

            $validator = Validator::make($input, $rules);

            if ($validator->fails()) {
                return Redirect::to("admin/products/{$product_id}/models/create")->withErrors($validator)->withInput();
            }
            
            $model = new ProductModel;
            $model->product_id = $product->id;
            $model->name = $input['name'];
            $model->description = $input['description'];
            $model->base_price = $input['base_price'];
            $model->min_price = $input['min_price'];
            $model->save();
            
            // upload image
            $image_file_name = $model->id . '.' . Input::file('image')->getClientOriginalExtension();
            $image = Input::file('image')->move(public_path() . '/assets/images/products', $image_file_name);
            $model->image = $image_file_name;
            $model->save();
            
            // Log entry
            $log = new \ActionLog;
            $log->user_id = \Sentry::getUser()->id;
            $log->item_id = $model->id;
            $log->item_type = 'model';
            $log->title = 'Created Model';
            $log->data = json_encode($input);
            $log->save();
            
            return Redirect::to("admin/products/{$product_id}/models/{$model->id}")->with('message', "Model {$input['name']} created");
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($product_id, $model_id)
	{
            $product = Product::findOrFail($product_id);
            $model = ProductModel::findOrFail($model_id);
            $properties = $model->propertyies;
	    return View::make('admin.products.models.show', array('product' => $product, 'model' => $model, 'properties' => $properties));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($product_id, $model_id)
	{
            $product = Product::findOrFail($product_id);
            $model = ProductModel::findOrFail($model_id);
            return View::make('admin.products.models.edit', array('product' => $product, 'model' => $model));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($product_id, $model_id)
	{
	    $product = Product::findOrFail($product_id);
            $model = ProductModel::findOrFail($model_id);
            
            $input = Input::all();
            
            $rules = array(
                'name' => 'required|max:128',
                'description' => 'max:256',
                'image' => 'mimes:jpeg,bmp,png,gif',
                'base_price' => 'required|numeric',
                'min_price' => 'required|numeric'
            );
            
            $validator = Validator::make($input, $rules);

            if ($validator->fails()) {
                return Redirect::to("admin/products/{$product_id}/models/{$model_id}/edit")->withErrors($validator)->withInput();
            }
            
            if(isset($input['image'])) {
                $image_file_name = $model->id . '.' . Input::file('image')->getClientOriginalExtension();
                $image = Input::file('image')->move(public_path() . '/assets/images/products', $image_file_name);
                $model->image = $image_file_name;
            }
            
            $model->name = $input['name'];
            $model->description = $input['description'];
            $model->base_price = $input['base_price'];
            $model->min_price = $input['min_price'];
            $model->save();
            
            // Log entry
            $log = new \ActionLog;
            $log->user_id = \Sentry::getUser()->id;
            $log->item_id = $model->id;
            $log->item_type = 'model';
            $log->title = 'Edited Model';
            $log->data = json_encode($input);
            $log->save();
            
            return Redirect::to("admin/products/{$product_id}/models/{$model_id}")->with('message', 'Model updated');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($product_id, $model_id)
	{
	    $product = Product::findOrFail($product_id);
            $model = ProductModel::findOrFail($model_id);
            $model->delete();
            
            ProductModelProperty::where('model_id', $model_id)->delete();
            
            // Log entry
            $log = new \ActionLog;
            $log->user_id = \Sentry::getUser()->id;
            $log->item_id = $model->id;
            $log->item_type = 'model';
            $log->title = 'Deleted Model';
            $log->data = json_encode($model->toArray());
            $log->save();
            
            return Redirect::to("admin/products/{$product->id}")->with('message', "Model {$model->name} deleted");
	}

}