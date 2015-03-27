<?php

class ProductsController extends \BaseController {

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
            $products = Product::all();
            return View::make('admin.products.index', array('products' => $products));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
            return View::make('admin.products.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
            $input = Input::all();

            $rules = array(
                'name' => 'required|max:32',
                'slug' => 'required|max:64|unique:products|alpha_dash'
            );

            $validator = Validator::make($input, $rules);

            if ($validator->fails()) {
                return Redirect::to('admin/products/create')->withErrors($validator)->withInput();
            }
            
            $default = isset($input['default']) ? 1 : 0;
            
            $logo = isset($input['logo']) ? $input['logo'] : 'logo.png';
            
            if ($default == 1) {
                Product::where('default', 1)->update(array('default' => 0));
            }
            
            $product = new Product;
            $product->name = $input['name'];
            $product->slug = strtolower($input['slug']);
            $product->logo = $logo;
            $product->default = $default;
            $product->save();
            
            // Log entry
            $log = new \ActionLog;
            $log->user_id = \Sentry::getUser()->id;
            $log->item_id = $product->id;
            $log->item_type = 'product';
            $log->title = 'Created Product';
            $log->data = json_encode($input);
            $log->save();
            
            return Redirect::to('admin/products/' . $product->id)->with('message', "Product {$input['name']} created!");
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
            $product = Product::findOrFail($id);
            $models = $product->models;
            return View::make('admin.products.show', array('product' => $product, 'models' => $models));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
            $product = Product::findOrFail($id);
	    return View::make('admin.products.edit', array('product' => $product));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
            $product = Product::findOrFail($id);
            $input = Input::all();

            $rules = array(
                'name' => 'required|max:32',
                'slug' => 'required|max:64|unique:products,slug,'.$id.'|alpha_dash'
            );

            $validator = Validator::make($input, $rules);

            if ($validator->fails()) {
                return Redirect::to("admin/products/{$id}/edit")->withErrors($validator)->withInput();
            }
            
            $default = isset($input['default']) ? 1 : 0;
            
            $logo = isset($input['logo']) ? $input['logo'] : 'logo.png';
            
            if ($default != $product->default) {
                Product::where('default', 1)->update(array('default' => 0));
            }
            
            $product->name = $input['name'];
            $product->slug = $input['slug'];
            $product->logo = $logo;
            $product->default = $default;
            $product->save();
            
            // Log entry
            $log = new \ActionLog;
            $log->user_id = \Sentry::getUser()->id;
            $log->item_id = $product->id;
            $log->item_type = 'product';
            $log->title = 'Edited Product';
            $log->data = json_encode($input);
            $log->save();
            
            return Redirect::to("admin/products/{$id}")->with('message', 'Product updated');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
	    $product = Product::findOrFail($id);
            $product->delete();
            
            // Log entry
            $log = new \ActionLog;
            $log->user_id = \Sentry::getUser()->id;
            $log->item_id = $product->id;
            $log->item_type = 'product';
            $log->title = 'Deleted Product';
            $log->data = json_encode($product->toArray());
            $log->save();
            
            return Redirect::to("admin/products")->with('message', 'Product deleted');
	}

}