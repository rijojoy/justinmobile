<?php

namespace Orders;

class OrdersController extends \BaseController {

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
            $status_id = \Input::get('status');
            $product_id = \Input::get('product');
           
            // lmao
            if (\Input::get('order')) {
                $order = \Order::find(\Input::get('order'));
                if ($order) {
                    return \Redirect::to('admin/orders/' . $order->id);
                } else {
                    return \Redirect::to('admin/orders')->with('message', 'No order ID ' . \Input::get('order') . ' can be found');
                }
            }
            
            // lmaox2
            if (\Input::get('imei')) {
                $order = \Order::where('imei', \Input::get('imei'))->first();
                if ($order) {
                    return \Redirect::to('admin/orders/' . $order->id);
                } else {
                    return \Redirect::to('admin/orders')->with('message', 'No order with the IMEI  ' . \Input::get('imei') . ' exists in the system');
                }
            }
            
            if (empty($status_id) && empty($product_id)) {
                $orders = \Order::where('created_at', '>', '0');
                $filter = false;
                $filter_val = false;
            } else if (!empty($status_id)) {
                $orders = \Order::where('status_id', $status_id);
                $filter = 'status';
                $filter_val = \OrderStatus::where('id', $status_id)->first();
            } else if (!empty($product_id)) {
                $orders = \Order::where('product_id', $product_id);
                $filter = 'product';
                $filter_val = \Product::where('id', $product_id)->first();
            }
            
            $orders = $orders->orderBy('updated_at', 'desc')->get();
            
            // lmaox3
            if (\Input::get('search')) {
                $orders = \Order::where('personal_info', 'LIKE', '%'.\Input::get('search').'%')->orderBy('updated_at', 'desc')->get();
            }
            
            $statuses = \OrderStatus::all();
            $products = \Product::all();
	    return \View::make('admin.orders.index', array(
                'orders' => $orders,
                'filter' => $filter,
                'filter_val' => $filter_val,
                'statuses' => $statuses,
                'products' => $products
            ));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
            
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
            $order = \Order::find($id);
            $statuses = \OrderStatus::all();
	    return \View::make('admin.orders.show', array(
                'order' => $order,
                'statuses' => $statuses,
            ));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
            $order = \Order::find($id);
            $statuses = \OrderStatus::all();
	    return \View::make('admin.orders.edit', array(
                'order' => $order,
                'statuses' => $statuses,
            ));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
            $input = \Input::all();
            $order = \Order::find($id);
            
            $personal_info = json_decode($order->personal_info, true);
            $imei = $input['imei'];
            
            foreach (array_slice(array_slice($input, 0, -1), 2) as $key => $value) {
                $personal_info[$key] = $value;
            }
            
            $order->personal_info = json_encode($personal_info);
            $order->imei = $imei;
            $order->save();
            
            // Log entry
            $log = new \ActionLog;
            $log->user_id = \Sentry::getUser()->id;
            $log->item_id = $order->id;
            $log->item_type = 'order';
            $log->title = 'Edited Order';
            $log->data = json_encode($personal_info);
            $log->save();
            
            return \Redirect::to('admin/orders/' . $order->id)->with('message', 'Order updated!');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}