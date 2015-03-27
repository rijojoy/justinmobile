<?php

class UsersController extends \BaseController {

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
            $users = \Sentry::findAllUsers();
            return View::make('admin.users.index', array('users' => $users));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
            return View::make('admin.users.create');
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
                'email'         => 'required|email',
                'first_name'    => 'required|min:1|max:32',
                'last_name'     => 'required|min:1|max:32',
                'avatar' => 'mimes:jpg,jpeg'
            );

            $validator = Validator::make($input, $rules);

            if ($validator->fails()) {
                return Redirect::to('admin/users/create')->withErrors($validator)->withInput();
            }

            try {
                $password = substr(md5(rand()), 0, 10);

                $user = \Sentry::createUser(array(
                    'email'         => $input['email'],
                    'password'      => $password,
                    'first_name'    => $input['first_name'],
                    'last_name'     => $input['last_name'],
                ));

                $group = \Sentry::findGroupById(1);
                $user->addGroup($group);
                
                $user->activated = 1;
                $user->save();
                
                if(Input::file('avatar')) {
                    Input::file('avatar')->move(public_path() . '/assets/images/avatars/', $user->id . '.jpg');
                }
                
                Mail::send('emails.users.created', array('user' => $user, 'password' => $password), function($message) use ($user) {
                    $message->from('system@recycle', 'Recycle');
                    $message->to($user->email, $user->first_name . ' ' . $user->last_name)->subject('Recycle account login details!');
                });

                // Log entry
                $log = new \ActionLog;
                $log->user_id = \Sentry::getUser()->id;
                $log->item_id = $user->id;
                $log->item_type = 'user';
                $log->title = 'Created User';
                $log->data = json_encode($input);
                $log->save();
                
            } catch (\Cartalyst\Sentry\Users\LoginRequiredException $e) {
                return Redirect::to('admin/users/create')->withErrors(['Email required'])->withInput();
            } catch (\Cartalyst\Sentry\Users\UserExistsException $e) {
                return Redirect::to('admin/users/create')->withErrors(['User already exists'])->withInput();
            }

            return Redirect::to('admin/users')->with('message', "User created with password {$password}, an email has been sent to {$input['email']}");
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
            try {
                $user = \Sentry::findUserById($id);
                return View::make('admin.users.show', array('user' => $user));
            } catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
                App::abort(404, 'User not found');
            }
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
            try {
                $user = \Sentry::findUserById($id);
                return View::make('admin.users.edit', array('user' => $user));
            } catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
                App::abort(404, 'User not found');
            }
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
            $user = \Sentry::findUserById($id);
            $input = Input::all();

            $rules = array(
                'email' => 'required|email',
                'first_name' => 'required|min:1|max:32',
                'last_name' => 'required|min:1|max:32',
                'avatar' => 'mimes:jpg,jpeg'
            );

            $validator = Validator::make($input, $rules);

            if ($validator->fails()) {
                return Redirect::to("admin/users/{$user->id}/edit")->withErrors($validator)->withInput();
            }

            try {
                $user->email = $input['email'];
                $user->first_name = $input['first_name'];
                $user->last_name = $input['last_name'];

                if ($user->save()) {
                    if(Input::file('avatar')) {
                        Input::file('avatar')->move(public_path() . '/assets/images/avatars/', $user->id . '.jpg');
                    }
                    
                    // Log entry
                    $log = new \ActionLog;
                    $log->user_id = \Sentry::getUser()->id;
                    $log->item_id = $user->id;
                    $log->item_type = 'user';
                    $log->title = 'Edited User';
                    $log->data = json_encode($input);
                    $log->save();

                    return Redirect::to("admin/users/{$user->id}")->with('message', 'User details have been changed');
                } else {
                    return Redirect::to("admin/users/{$user->id}/edit")->withErrors(['User details could not be updated'])->withInput();
                }
            } catch (\Cartalyst\Sentry\Users\UserExistsException $e) {
               return Redirect::to("admin/users/{$user->id}/edit")->withErrors(['Email address already in use by another user'])->withInput();
            } catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
               return Redirect::to("admin/users/{$user->id}/edit")->withErrors(['User not found? huh'])->withInput();
            }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
	    $user = \Sentry::findUserById($id);
            $user->delete();
            
            // Log entry
            $log = new \ActionLog;
            $log->user_id = \Sentry::getUser()->id;
            $log->item_id = $user->id;
            $log->item_type = 'user';
            $log->title = 'Deleted User';
            $log->data = json_encode($user->toArray());
            $log->save();
            
            return Redirect::to("admin/users")->with('message', "{$user->email} has been deleted");
	}

}