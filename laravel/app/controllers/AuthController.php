<?php

class AuthController extends \BaseController {
    
    public function getIndex() {
        if(Sentry::getUser()) {
            return Redirect::to('admin/dashboard');
        } else {
            return Redirect::to('admin/auth/login');
        }
    }
    
    public function getLogin() {
        return View::make('admin.auth.login');
    }
    
    public function postLogin() {
        $input = Input::all();
        
        $rules = array(
            'email' => 'required|email',
            'password' => 'required'
        );
        
        $validator = Validator::make($input, $rules);
        
        if ($validator->fails()) {
            return Redirect::to('admin/auth/login')->withErrors($validator);
        }
        
        try {
            $credentials = array(
                'login'     => $input['email'],
                'password'  => $input['password']
            );
            
            $user = \Sentry::authenticate($credentials, true);
            
            return Redirect::to('admin/dashboard');
        } catch (\Cartalyst\Sentry\Users\LoginRequiredException $e) {
            return Redirect::to('admin/auth/login')->withErrors(['Email and password required']);
        } catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
            return Redirect::to('admin/auth/login')->withErrors(['Login details are not valid']);
        }
    }
    
    public function getForgot() {
        return View::make('admin.auth.forgot');
    }
    
    public function postForgot() {
        $input = Input::all();
        
        $rules = array(
            'email' => 'required|email'
        );
        
        $validator = Validator::make($input, $rules);
        
        if ($validator->fails()) {
            return Redirect::to('admin/auth/forgot')->withErrors($validator);
        }
        
        try {
            $user = \Sentry::findUserByCredentials(array(
                'email' => $input['email']
            ));
            
            $reset_code = $user->getResetPasswordCode();
            
            Mail::send('emails.users.reset', array('user' => $user, 'reset_code' => $reset_code), function($message) use ($user) {
                $message->from('system@recycle', 'Recycle');
                $message->to($user->email, $user->first_name . ' ' . $user->last_name)->subject('Recycle password reset');
            });
        } catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
            return Redirect::to('admin/auth/forgot')->withErrors(['No user found']);
        }
        
        return Redirect::to('admin/auth/forgot')->with('message', 'An email has been sent to '.$user->email.' with a reset code');
    }
    
    public function getReset($code) {
        return View::make('admin.auth.reset', array('code' => $code));
    }
    
    public function postReset() {
        $input = Input::all();
        
        $rules = array(
            'email' => 'required|email',
            'password' => 'required|min:6',
            'password_confirm' => 'required|same:password',
            'code' => 'required'
        );
        
        $validator = Validator::make($input, $rules);
        
        if ($validator->fails()) {
            return Redirect::to('admin/auth/reset/' . $input['code'])->withErrors(
                $validator
            );
        }
        
        try {
            $user = \Sentry::findUserByCredentials(array(
                'email' => $input['email']
            ));
            
            if ($user->checkResetPasswordCode($input['code'])) {
                if ($user->attemptResetPassword($input['code'], $input['password'])) { 
                    return Redirect::to('admin/auth/login')->with('message', 'Your password has been set! You can now log in with that password.');
                } else {
                    return Redirect::to('admin/auth/forgot');
                }
            } else {
                return Redirect::to('admin/auth/reset/' . $input['code'])->withErrors(
                    ['Invalid reset key']
                );
            }
        } catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
            return Redirect::to('admin/auth/reset/' . $input['code'])->withErrors(
                ['User not found']
            );
        }
    }
    
    public function getLogout() {
        \Sentry::logout();
        return Redirect::to('admin/auth/login')->with('message', 'You have been logged out');
    }

}