<?php

/*
|--------------------------------------------------------------------------
| Register The Laravel Class Loader
|--------------------------------------------------------------------------
|
| In addition to using Composer, you may use the Laravel class loader to
| load your controllers and models. This is useful for keeping all of
| your classes in the "global" namespace without Composer updating.
|
*/

ClassLoader::addDirectories(array(

	app_path().'/commands',
	app_path().'/controllers',
	app_path().'/models',
	app_path().'/database/seeds',

));

/*
|--------------------------------------------------------------------------
| Application Error Logger
|--------------------------------------------------------------------------
|
| Here we will configure the error logger setup for the application which
| is built on top of the wonderful Monolog library. By default we will
| build a rotating log file setup which creates a new file each day.
|
*/

$logFile = 'log-'.php_sapi_name().'.txt';

Log::useDailyFiles(storage_path().'/logs/'.$logFile);

/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/

App::error(function(Exception $exception, $code)
{
	Log::error($exception);
});

/*
|--------------------------------------------------------------------------
| Maintenance Mode Handler
|--------------------------------------------------------------------------
|
| The "down" Artisan command gives you the ability to put an application
| into maintenance mode. Here, you will define what is displayed back
| to the user if maintenace mode is in effect for this application.
|
*/

App::down(function()
{
	return Response::make("Be right back!", 503);
});

/*
|--------------------------------------------------------------------------
| Require The Filters File
|--------------------------------------------------------------------------
|
| Next we will load the filters file for the application. This gives us
| a nice separate location to store our route and application filter
| definitions instead of putting them all in the main routes file.
|
*/


/* Setup the Cron Jobs Here */
Event::listen('cron.collectJobs', function() {
    Cron::add('reminder1', '* * * * *', function() {
                    // Do some crazy things unsuccessfully every minute
                    $orders = \Order::select(DB::Raw("DATEDIFF(now(),`updated_at`) as 'daysold'"),'id','product_id','personal_info','status_id')->OrderBy(DB::Raw("DATEDIFF(now(),`updated_at`)"),'DESC')->get();
                    /* Select Template */
                    $selectTpl1 = \OrderNoteTemplate::where('id','=',19)->paginate(1);
                    $selectTpl7 = \OrderNoteTemplate::where('id','=',11)->paginate(1);
                    $selectTpl14 = \OrderNoteTemplate::where('id','=',18)->paginate(1);
                    /* End of Select Template */
                    
                    /* loop all orders */
                    foreach( $orders as $order)
                    {
                        
                                           
                        if($order->daysold == 1)
                        {
                             
                            $orderNote1 = \OrderNote::where('order_id', '=', $order->id)->where('status_id','=',2)->first();
                            $odId = $orderNote1;
                            if($orderNote1 == null)
                             {
                                   $person = json_decode($order->personal_info, true);
                                    $tpl1 = str_replace('%%name%%',$person['name'],$selectTpl1[0]->body);
                                        $note = new \OrderNote;
                                        $note->order_id = $order->id;
                                        $note->status_id = 2;
                                        $note->user_id = 9;
                                        $note->body = $tpl1;
                                        $note->send_email = 1;
                                        $note->byline = "1 day reminder sent";
                                        $note->save();

                                        $order = \Order::findOrFail($order->id);
                                        $order->status_id = 2;
                                        $order->save();
                                     /* Its time to send email */
                            \Mail::send('emails.orders.updated', array('body' => $tpl1), function($message) use ($order) {
                            $person = json_decode($order->personal_info, true);
                            $message->from(\Config::get('mail.from.address'), \Config::get('mail.from.name'));
                            $message->to($person['email'], $person['name'])->subject('Sell Order #' . $order->id . ' Update');
                        });
                            /* End of its time to send email */   
                             }
                        }
                        
                        /* 7 Days Reminder */
                        if($order->daysold == 7)
                        {
                            $orderNote1 = \OrderNote::where('order_id', '=', $order->id)->where('status_id','=',12)->first();
                            $odId = $orderNote1;
                            if($orderNote1 == null)
                             {
                                    $person = json_decode($order->personal_info, true);
                                    $tpl7 = str_replace('%%name%%',$person['name'],$selectTpl7[0]->body);
                                        $note = new \OrderNote;
                                        $note->order_id = $order->id;
                                        $note->status_id = 12;
                                        $note->user_id = 9;
                                        $note->body = $tpl7;
                                        $note->send_email = 1;
                                        $note->byline = "7 day reminder sent";
                                        $note->save();

                                        $order = \Order::findOrFail($order->id);
                                        $order->status_id = 12;
                                        $order->save();
                                     /* Its time to send email */
                            \Mail::send('emails.orders.updated', array('body' => $tpl7), function($message) use ($order) {
                            $person = json_decode($order->personal_info, true);
                            $message->from(\Config::get('mail.from.address'), \Config::get('mail.from.name'));
                            $message->to($person['email'], $person['name'])->subject('Sell Order #' . $order->id . ' Update');
                        });
                            /* End of its time to send email */   
                             }
                        }
                        /* End of 7 Days Reminder */
                        
                        
                         /* 14 Days Reminder */
                        if($order->daysold == 14)
                        {
                            $orderNote1 = \OrderNote::where('order_id', '=', $order->id)->where('status_id','=',15)->first();
                            $odId = $orderNote1;
                            if($orderNote1 == null)
                             {
                                    $person = json_decode($order->personal_info, true);
                                    $tpl14 = str_replace('%%name%%',$person['name'],$selectTpl14[0]->body);
                                        $note = new \OrderNote;
                                        $note->order_id = $order->id;
                                        $note->status_id = 15;
                                        $note->user_id = 9;
                                        $note->body = $tpl14;
                                        $note->send_email = 1;
                                        $note->byline = "14 day reminder sent";
                                        $note->save();

                                        $order = \Order::findOrFail($order->id);
                                        $order->status_id = 15;
                                        $order->save();
                                     /* Its time to send email */
                            \Mail::send('emails.orders.updated', array('body' => $tpl14), function($message) use ($order) {
                            $person = json_decode($order->personal_info, true);
                            $message->from(\Config::get('mail.from.address'), \Config::get('mail.from.name'));
                            $message->to($person['email'], $person['name'])->subject('Sell Order #' . $order->id . ' Update');
                        });
                            /* End of its time to send email */   
                             }
                        }
                        /* End of 14 Days Reminder */
                    
                        
                    }
                    /* End of loop all orders */
                    
                    
                    return $odId;
                });

    Cron::add('reminder7', '*/2 * * * *', function() {
        // Do some crazy things successfully every two minute
        return null;
    });

    Cron::add('reminder14', '0 * * * *', function() {
        // Do some crazy things successfully every hour
    }, false);
});
/* End of setup Cron Jobs Here */

require app_path().'/filters.php';