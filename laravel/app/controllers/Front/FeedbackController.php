<?php

namespace Front;

use Input;
use Mail;
use Order;
use Redirect;
use Response;
use Validator;

class FeedbackController extends \BaseController {
    
    public function postSubmit() {
		$input = Input::all();
		
		$rules = array(
			'message' => 'required|min:5|max:10000',
			'order_id' => 'required|numeric'
		);
		
		$validator = Validator::make($input, $rules);
		
		if ($validator->fails()) {
			return Redirect::to('thankyou?order=' . $input['order_id'])->withErrors($validator)->withInput();
		}
	
		$order = Order::findOrFail($input['order_id']);
		
		\Mail::send('emails.feedback', array('input' => $input, 'order' => $order), function($message) {
			$message->from(\Config::get('mail.from.address'), \Config::get('mail.from.name'));
			$message->to(\Config::get('mail.feedback.address'), \Config::get('mail.from.name'))->subject('Sell Order Feedback');
		});
		
		return Redirect::to('thankyou?order=' . $input['order_id'])->with('message', 'Your feedback has been taken, thank you!')->withInput();
	}

}
    