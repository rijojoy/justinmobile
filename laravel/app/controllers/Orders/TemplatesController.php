<?php

namespace Orders;

class TemplatesController extends \BaseController {

        public function __construct() {
            $this->beforeFilter('auth');

            $statuses = \OrderStatus::all();
            foreach ($statuses as $status) {
                $status_list[$status->id] = $status->name;
            }
            
            $this->statuses = $status_list;
        }
    
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
            $templates = \OrderNoteTemplate::all();
	    return \View::make('admin.orders.templates.index', array('templates' => $templates));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
	    return \View::make('admin.orders.templates.create', array('statuses' => $this->statuses));
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
                'status_id' => 'in:' . implode(",", array_keys($this->statuses)),
                'body' => 'min:1'
            );
            
            $validator = \Validator::make($input, $rules);
            
            if ($validator->fails()) {
                return \Redirect::to('admin/orders/templates/create')->withErrors($validator)->withInput();
            }
            
            $template = new \OrderNoteTemplate;
            $template->name = $input['name'];
            $template->status_id = $input['status_id'];
            $template->body = $input['body'];
            $template->send_email = isset($input['send_email']) ? 1 : 0;
            $template->save();
            
            // Log entry
            $log = new \ActionLog;
            $log->user_id = \Sentry::getUser()->id;
            $log->item_id = $template->id;
            $log->item_type = 'template';
            $log->title = 'Created Template';
            $log->data = json_encode($input);
            $log->save();
            
            return \Redirect::to('admin/orders/templates')->with('message', 'Template created!');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
	    return \Redirect::to('admin/orders/templates/' . $id . '/edit');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
            $template = \OrderNoteTemplate::findOrFail($id);
	    return \View::make('admin.orders.templates.edit', array('template' => $template, 'statuses' => $this->statuses));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
            $template = \OrderNoteTemplate::findOrFail($id);
            
	    $input = \Input::all();
            
            $rules = array(
                'name' => 'required|max:128',
                'status_id' => 'in:' . implode(",", array_keys($this->statuses)),
                'body' => 'min:1'
            );
            
            $validator = \Validator::make($input, $rules);
            
            if ($validator->fails()) {
                return \Redirect::to('admin/orders/templates/'. $id . '/edit')->withErrors($validator)->withInput();
            }
            
            $template->name = $input['name'];
            $template->status_id = $input['status_id'];
            $template->body = $input['body'];
            $template->send_email = isset($input['send_email']) ? 1 : 0;
            $template->save();
            
            // Log entry
            $log = new \ActionLog;
            $log->user_id = \Sentry::getUser()->id;
            $log->item_id = $template->id;
            $log->item_type = 'template';
            $log->title = 'Edited Template';
            $log->data = json_encode($input);
            $log->save();
            
            return \Redirect::to('admin/orders/templates')->with('message', 'Template updated!');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
	    $template = \OrderNoteTemplate::findOrFail($id);
            $template->delete();
            
            // Log entry
            $log = new \ActionLog;
            $log->user_id = \Sentry::getUser()->id;
            $log->item_id = $id;
            $log->item_type = 'template';
            $log->title = 'Deleted Template';
            $log->data = json_encode($template->toArray());
            $log->save();
            
            return \Redirect::to('admin/orders/templates')->with('message', 'Template deleted');
	}

}