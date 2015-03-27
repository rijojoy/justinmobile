@extends('layouts.admin.admin')

@section('breadcrumbs')
    <?php $breadcrumbs = array(
        ['icon' => 'book', 'label' => 'Documentation', 'url' => 'documentation'],
    ); ?>
    @include('admin._bits.breadcrumb', $breadcrumbs)
@stop

@section('content')
<div class="row" id="documentation">
    <div class="col-md-8">
        <div class="box">
            <div class="box-header"><span class="title">Documentation</span></div>
            <div class="box-content padded">
				<h1>Managing E-Mails</h1>
					<h2>New order</h2>
					<p>
						The email sent to a customer when they create a new order is
						set in the following file:
						
<pre>
laravel\app\views\emails\orders\created.blade.php
</pre>

						The tokens available in this template are:

						<ul>
							<li><strong>name</strong> Full name of the customer</li>
							<li><strong>order_id</strong> Numerical ID of the order (eg: 27)</li>
							<li><strong>product</strong> Name of the product (eg: "iPhone")</li>
							<li><strong>model</strong> Name of the model (eg: "5s")</li>
							<li><strong>price</strong> Final price of the order (eg: 425.00)</li>
						</ul>

						Tokens can be output using double curly braces either side with a $, for example:

<pre>
Hello @{{ $name }}, your @{{ $product }} @{{ $model }} is worth &pound;@{{ $price }}
</pre>

						would become:

<pre>
Hello John Doe, your iPhone 5s is worth &pound;425.00
</pre>
					</p>
				<h2>Order update</h2>
				<p>
					The email sent to users when "Send email" is selected on an order update is set in the following file:
					
<pre>
laravel\app\views\emails\orders\updated.blade.php
</pre>
						
					The contents of this email are taken from the order update itself, so there are no tokens available.
				</p>
				<h1>Adding a new page</h1>
				<p>
					A new page can be added by creating a route and creating a template. A template should be named
					"page.blade.php" and placed in the front folder:
					
<pre>
laravel\app\views\front
</pre>
					
					The page must extend the parent layout, for example:
					
<pre>
@<span style="display:none;">-</span>extends('layouts.front.front')

@<span style="display:none;">-</span>section('content')

@<span style="display:none;">-</span>stop
</pre>
					
					This will use the front end layout and include all of the navigation automatically. The content should be placed between the section declaration,
					for example to make a contact page that says "Hello, email is example@example.org" the following would be used:
					
<pre>
@<span style="display:none;">-</span>extends('layouts.front.front')

@<span style="display:none;">-</span>section('content')
Hello, email is example@example.org
@<span style="display:none;">-</span>stop
</pre>
					
					Routes are added in the file:
					
<pre>
laravel\app\routes.php
</pre>
					
					and a route looks like:
					
<pre>
Route::get('/page', function () {
$products = Product::all();
return View::make('front.page', array('products' => $products));
});
</pre>
					
					For example to create a route for a page called "contact" it would be as follows:
					
<pre>
Route::get('/contact', function () {
$products = Product::all();
return View::make('front.contact', array('products' => $products));
});
</pre>
				</p>
            </div>
        </div>
    </div>
</div>
@stop