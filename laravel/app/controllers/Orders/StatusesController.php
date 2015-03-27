<?php

namespace Orders;

class StatusesController extends \BaseController {

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
            $statuses = \OrderStatus::all();
	    return \View::make('admin.orders.statuses.index', array('statuses' => $statuses));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
	    return \View::make('admin.orders.statuses.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
	    $input = \Input::all();
            
            $rules = array(
                'name' => 'required|max:128',
                'class' => 'required|alpha_dash'
            );
            
            $validator = \Validator::make($input, $rules);
            
            if ($validator->fails()) {
                return \Redirect::to('admin/orders/statuses/create')->withErrors($validator)->withInput();
            }
            
            $status = new \OrderStatus;
            $status->name = $input['name'];
            $status->class = $input['class'];
            $status->save();
            
            // Log entry
            $log = new \ActionLog;
            $log->user_id = \Sentry::getUser()->id;
            $log->item_id = $status->id;
            $log->item_type = 'status';
            $log->title = 'Created Status';
            $log->data = json_encode($input);
            $log->save();
            
            return \Redirect::to('admin/orders/statuses/')->with('message', 'Status created!');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
            return \Redirect::to('admin/orders/statuses/' . $id . '/edit');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$status = \OrderStatus::findOrFail($id);
                return \View::make('admin.orders.statuses.edit', array('status' => $status));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
	    $status = \OrderStatus::findOrFail($id);
            
	    $input = \Input::all();
            
            $rules = array(
                'name' => 'required|max:128',
                'class' => 'required|alpha_dash'
            );
            
            $validator = \Validator::make($input, $rules);
            
            if ($validator->fails()) {
                return \Redirect::to("admin/orders/statuses/{$id}/edit")->withErrors($validator)->withInput();
            }
            
            $status->name = $input['name'];
            $status->class = $input['class'];
            $status->save();
            
            // Log entry
            $log = new \ActionLog;
            $log->user_id = \Sentry::getUser()->id;
            $log->item_id = $status->id;
            $log->item_type = 'status';
            $log->title = 'Edited Status';
            $log->data = json_encode($input);
            $log->save();
            
            return \Redirect::to('admin/orders/statuses')->with('message', 'Status updated!');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
	    $status = \OrderStatus::findOrFail($id);
            $status->delete();
            
            // Log entry
            $log = new \ActionLog;
            $log->user_id = \Sentry::getUser()->id;
            $log->item_id = $status->id;
            $log->item_type = 'status';
            $log->title = 'Deleted Status';
            $log->data = json_encode($status->toArray());
            $log->save();
            
            return \Redirect::to('admin/orders/statuses')->with('message', 'Status deleted');
	}

}