<?php

namespace Orders;

class NotesController extends \BaseController {

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
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($order_id)
	{
            $template = false;
            if (\Input::get('template'))  {
                $template = \OrderNoteTemplate::findOrFail(\Input::get('template'));
            }
            
            $order = \Order::findOrFail($order_id);
            $template_list = \OrderNoteTemplate::all();
            
            $templates[0] = 'Select a template';
            
            foreach ($template_list as $temp) {
                $templates[$temp->id] = $temp->name;
            }
            
	    return \View::make('admin.orders.notes.create', array(
                'order' => $order,
                'statuses' => $this->statuses,
                'template' => $template,
                'templates' => $templates
            ));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($order_id)
	{
            $order = \Order::findOrFail($order_id);
            
            $input = \Input::all();
            
            $rules = array(
                'status_id' => 'in:' . implode(",", array_keys($this->statuses)),
            );
            
            $validator = \Validator::make($input, $rules);
            
            if ($validator->fails()) {
                return \Redirect::to('admin/orders/'.$order->id.'/notes/create')->withErrors($validator)->withInput();
            }
            
            if (empty($note->body)) {
                $byline = 'changed order status';
            } else if (isset($input['send_email'])) {
                $byline = 'sent an email to the customer';
            } else if (!isset($input['send_email']) && !empty($note->body)) {
                $byline = 'added a private note';
            }
            
            $note = new \OrderNote;
            $note->order_id = $order->id;
            $note->status_id = $input['status_id'];
            $note->user_id = \Sentry::getUser()->id;
            $note->body = $input['body'];
            $note->send_email = isset($input['send_email']) ? 1 : 0;
            $note->byline = $byline;
            $note->save();
            
            $order->status_id = $input['status_id'];
            $order->save();
            
            if($note->send_email == 1) {
                \Mail::send('emails.orders.updated', array('body' => $note->body), function($message) use ($order) {
                    $person = json_decode($order->personal_info, true);
                    $message->from(\Config::get('mail.from.address'), \Config::get('mail.from.name'));
                    $message->to($person['email'], $person['name'])->subject('Sell Order #' . $order->id . ' Update');
                });
            }
            
            // Log entry
            $log = new \ActionLog;
            $log->user_id = \Sentry::getUser()->id;
            $log->item_id = $note->id;
            $log->item_type = 'note';
            $log->title = 'Updated Order';
            $log->data = json_encode($input);
            $log->save();
            
            return \Redirect::to('admin/orders/' . $order_id)->with('message', 'Status updated & note added!');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		// not supported
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		// not supported
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		// not supported
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		// not supported
	}

}