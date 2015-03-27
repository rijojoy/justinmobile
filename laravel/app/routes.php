<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the Closure to execute when that URI is requested.
  |
 */

// SIMPLE PAGES

$pages = array_slice(scandir(base_path() . '/app/views/pages/'), 2);
array_walk($pages, function(&$value, $key) {
    $value = strtolower(str_replace('.blade.php', '', $value));
});

foreach ($pages as $page)
{
    Route::get("/{$page}", function () use ($page) {
        $products = Product::all();
        return View::make('front.page', array(
                    'plain_page' => 'pages/' . $page,
                    'products' => $products
        ));
    });
}

// FRONT

Route::get('/', 'Front\ProductsController@getProduct');
Route::get('/sell/{product}', 'Front\ProductsController@getProduct');
Route::post('/', 'Front\ProductsController@postOrder');

/*
  Route::get('/contact', function (){
  $products = Product::all();
  return View::make('front.contact', array('products' => $products));
  });

  Route::get('/about-us', function () {
  $products = Product::all();
  return View::make('front.about', array('products' => $products));
  });

  Route::get('/guides', function () {
  $products = Product::all();
  return View::make('front.guides', array('products' => $products));
  });

  Route::get('/privacy', function () {
  $products = Product::all();
  return View::make('front.privacy', array('products' => $products));
  });

  Route::get('/terms', function () {
  $products = Product::all();
  return View::make('front.terms', array('products' => $products));
  });
 */

Route::get('/thankyou', function () {
    $products = Product::all();
    $encrypted_id = Input::get('order');
    $order_id = \Crypt::decrypt($encrypted_id);

    $order = \Order::find($order_id);
    $options_cache = json_decode($order->options_cache, true);
    $order_info = json_decode($order->order_info, true);
    $personal_info = json_decode($order->personal_info, true);
    $status = null;
    foreach ($order_info['properties'] as $property_id => $option_id)
            {
                $value = $options_cache[$option_id]['name'];
                if ($value == 'I will print it')
                {
                    $status = 1;
                    break;
                }
                if ($value == 'Post it to me')
                {
                    $status = 0;
                    break;
                }
            }
    return View::make('front.thankyou', array('order_id' => $encrypted_id, 'status' => $status, 'products' => $products, 'personal_info' => $personal_info));
});


Route::get('/tyvm', function () {
    $products = Product::all();
    $encrypted_id = Input::get('order');
    $order_id = \Crypt::decrypt($encrypted_id);

    $order = \Order::find($order_id);
    $options_cache = json_decode($order->options_cache, true);
    $order_info = json_decode($order->order_info, true);
    $personal_info = json_decode($order->personal_info, true);
    $status = null;
    foreach ($order_info['properties'] as $property_id => $option_id)
            {
                $value = $options_cache[$option_id]['name'];
                if ($value == 'I will print it')
                {
                    $status = 1;
                    break;
                }
                if ($value == 'Post it to me')
                {
                    $status = 0;
                    break;
                }
            }
    return View::make('front.thankyou', array('order_id' => $encrypted_id, 'status' => $status, 'products' => $products, 'personal_info' => $personal_info));
});


Route::controller('/feedback', 'Front\FeedbackController');

// ADMIN

Route::get('/admin', function() {
    return Redirect::to('admin/auth');
});

Route::controller('admin/auth', 'AuthController');

Route::group(array('prefix' => 'admin'), function() {
    Route::controller('dashboard', 'DashboardController');

    Route::get('/documentation', function () {
        return View::make('admin.documentation.index');
    });

    Route::resource('products', 'ProductsController');
    Route::resource('products.models', 'ModelsController');
    Route::resource('products.models.properties', 'PropertiesController');
    Route::resource('products.models.properties.options', 'OptionsController');

    Route::resource('orders/templates', 'Orders\TemplatesController');
    Route::resource('orders/statuses', 'Orders\StatusesController');
    Route::resource('orders', 'Orders\OrdersController');

    Route::resource('orders.notes', 'Orders\NotesController');

    Route::resource('users', 'UsersController');
});

//App::error(function(Exception $exception) {
//    echo "<pre>";
//    var_dump($exception);
//    echo "</pre>";
//});

App::missing(function($exception) {
    return Response::view('admin._bits.404');
});