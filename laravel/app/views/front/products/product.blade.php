@extends('layouts.front.front')

@section('content')

<div class="row">
    <div class="col-sm-10">
        <div>
			<?php if (file_exists(public_path() . '/assets/images/homepage-banner_' . $product->name . '.jpg')) {
				$banner_file = $product->name; 
			} else {
				$banner_file = 'iPhone';
			} ?>
            <img src="/assets/images/homepage-banner_{{ $product->name}}.jpg" alt="Sell my iPhone 5S" class="img-responsive" />
        </div>
    </div>
  <div class="col-sm-2 trustpilotcg" style="height:auto; max-height: 210px;padding-right: 0px;padding-left: 1px;">
<div class="reviewfordesktop" style="margin-top: 22px;">  
<div class="tp_-_box" data-tp-settings="domainId:7844526,showComplementaryText:False,showDate:False,numOfReviews:10,useDynamicHeight:False,height:1565">
<a href="https://www.trustpilot.co.uk/review/www.geckomob..." rel="nofollow" hidden>Justin Mobile Recycling Reviews</a>
</div>
<script type="text/javascript">
(function () { var a = "https:" == document.location.protocol ? "https://s.trustpilot.com" : "http://s.trustpilot.com", b = document.createElement("script"); b.type = "text/javascript"; b.async = true; b.src = a + "/tpelements/tp_elements_all.js"; var c = document.getElementsByTagName("script")[0]; c.parentNode.insertBefore(b, c) })();
</script> 
  </div>
</div>
<!-- for mobile phones -->
<!-- <div class="reviewformobiles"> 
<!-- <div class="tp_-_box" data-tp-settings="domainId:7844526,showComplementaryText:False,showDate:False,width:314,numOfReviews:1"> 
 <a href="https://www.trustpilot.co.uk/review/www.geckomob..." rel="nofollow" hidden>Justin Mobile Recycling Reviews</a> 
</div>
<!-- <script type="text/javascript">
(function () { var a = "https:" == document.location.protocol ? "https://s.trustpilot.com" : "http://s.trustpilot.com", b = document.createElement("script"); b.type = "text/javascript"; b.async = true; b.src = a + "/tpelements/tp_elements_all.js"; var c = document.getElementsByTagName("script")[0]; c.parentNode.insertBefore(b, c) })();
</script> -->

</div> 
</div> 

<hr></hr>


    <div class="col-md-10">
        <div class="heading">
            <h3>Step 1: Click your <strong>{{ $product->name }}</strong></h3>
        </div>
    </div>
   <div class="col-md-10">


     <div class="row models">
    @foreach ($product->models as $model)
    <div class="col-md-3">
        <div class="panel panel-gecko model" data-model="{{ $model->id }}" id="model-{{ $model->id }}" data-baseprice="{{ $model->base_price }}" data-minprice="{{ $model->min_price }}">
            <div class="panel-body">
                <a class="select-model" data-model="{{ $model->id }}" data-baseprice="{{ $model->base_price }}" data-minprice="{{ $model->min_price }}" href="#" onclick="hideImage();">
                    <img src="/assets/images/products/{{ $model->id }}.png" alt="{{ $model->name }}">
                </a>
            </div>
            <div class="panel-footer">
                <a class="select-model" data-model="{{ $model->id }}" data-baseprice="{{ $model->base_price }}" data-minprice="{{ $model->min_price }}" href="#" onclick="hideImage();">{{ $product->name }} <small>{{ $model->name }}</small></a>
            </div>
        </div>
    </div>
    @endforeach
</div>

     
   </div>
<div class="col-md-10">
<div class="row" id="optionstuff">
    <div class="col-md-6">
        <div class="heading">
            <h3>
                Step 2: Your <strong>{{ $product->name }}</strong> options
            </h3>
        </div>
        <div class="step opts">
             <img src="https://www.geckomobilerecycling.co.uk/assets/images/Gecko-speechbubble.png" style="width: 100%;" id="cgImage">
            @foreach ($product->models as $model)
            <div class="model-properties" data-model="{{ $model->id }}">
                <?php $i = 0; $cgp= 0;?>
                @foreach ($model->propertyies()->get() as $property) 
                <?php $i++; $disabled = ($i > 1) ? 'disabled' : ''; ?>
                <div class="property" data-type="{{ $property->type }}" data-id="{{ $property->id }}" data-required="{{ $property->required }}">
                    <h5>
                        {{ $property->title }}
                        @if ($property->help_text)
                       <a href="#info" data-toggle="modal" data-target="#help-property-{{ $property->id }}"><!--<span class="glyphicon glyphicon-info-sign"></span>--><span class="glyphicon">Help</span>
                        @endif
                        <a href="#explain" class="property-explanation-edit" data-toggle="modal" data-target="#explain-property-{{ $property->id }}"><span class="glyphicon glyphicon-pencil"></span></a>
                        @if ($property->required == 0)
                        <a href="#skip" class="property-skip hidden-option" data-id="{{ $property->id }}"><!--<span class="glyphicon glyphicon-chevron-right" title="skip"></span>--></a>
                        <?php $cgp = 1; ?> 
                        @endif
                    </h5>
                    <div class="property-explanation">
                        <div class="modal fade" id="explain-property-{{ $property->id }}" tabindex="-1" role="dialog" aria-labelledby="explain-property-label-{{ $property->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="explain-property-label-{{ $property->id }}">{{ $property->explanation_name }}</h4>
                                    </div>
                                    <div class="modal-body">
                                        <p>
                                            {{ $property->explanation_description }}
                                        </p>
                                        <textarea id="explanation-{{ $property->id }}" class="form-control explanation" data-property="{{ $property->id }}" rows="6"></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="property-help">
                        @if ($property->help_text)
                        <div class="modal fade" id="help-property-{{ $property->id }}" tabindex="-1" role="dialog" aria-labelledby="help-property-label-{{ $property->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="help-property-label-{{ $property->id }}">{{ $property->name }}</h4>
                                    </div>
                                    <div class="modal-body">
                                        {{ $property->help_text }}
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="btn-group">
                    @foreach ($property->options()->get() as $option)
                    <button type="button" title="{{ $option->name }}" class="btn btn-lg btn-default option-selection" data-id="{{ $option->id }}" data-mtype="{{ $option->modifier_type }}" data-mamt="{{ $option->modifier_amount }}" data-explanation="{{ $option->explanation }}" {{ $disabled }}>{{ $option->name }}</button>
                    @endforeach
                    </div>
                </div>
                @endforeach
            </div>
            @endforeach
            <div id="price">
                <h4>Our offer</h4>
                <h2>£<span id="price-value">00.00</span></h2>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="heading">
            <h3>Step 3: Your Details (encrypted)</strong></h3>
        </div>
        <div class="step">
            <div class="details-submit-error alert alert-danger">
                <strong>Error!</strong>
            </div>
            <form role="form" class="horizontal-form" method="post" id="details-form">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Full Name" required disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required disabled>
                        </div>
                    </div>
                </div>
				{{--
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="packaging">Postage & Packaging</label>
                            <select name="packaging" id="packaging" class="form-control" disabled>
                                <option value="post" selected="selected">I’ll post the {{ $product->name }} to you myself (faster)</option>
								<option value="provide">Provide pre-paid packaging (free)</option>
                            </select>
                            <p class="help-block switchable-help" id="packaging-post">
                                Once you've registered your sale we'll send you an email with instructions including where to send your {{ $product->name }}
                            </p>
                            <p class="help-block switchable-help" id="packaging-provide">
                                We will send you a jiffy bag with 1st class recorded postage pre-paid.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="device-network">Device Network</label>
                            <select name="device-network" id="device-network" class="form-control" disabled>
                                <?php $networks = ['unknown' => 'Unknown', 'o2' => 'O2', 'vodafone' => 'Vodafone', 'three' => 'Three', 'orange' => 'Orange', 'unlocked' => 'Unlocked']; ?>
                                @foreach ($networks as $key => $network)
                                <option value="{{ $key }}">{{ $network }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
				--}}
                
                <div class="row">
                    <div class="col-md-6">
                         <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number" required disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="payment">Payment Method (no charges)</label>
                            <select name="payment" id="payment" class="form-control" disabled>
                                <option value="bank" selected="selected">Instant bank transfer</option>
                                <option value="cheque">Cheque</option>
								<option value="paypal">PayPal</option>
								<option value="bitcoin">Bitcoin</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div id="payment-methods">
                    <!-- bank -->
                    <div class="row payment-method default" id="payment-bank">
                        <div class="col-md-6">
                             <div class="form-group">
                                <label for="bank-accountnumber">Account Number</label>
                                <input type="text" class="form-control" id="bank-accountnumber" name="bank-accountnumber" placeholder="Account Number" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bank-sortcode">Sort Code</label>
                                <input type="text" class="form-control" id="bank-sortcode" name="bank-sortcode" placeholder="Sort Code" disabled>
                            </div>
                        </div>
                    </div>
                    <!-- cheque -->
                    <div class="row payment-method" id="payment-cheque">
                        <div class="col-md-12">
                             <div class="form-group">
                                <label for="cheque-name">Name on Cheque</label>
                                <input type="text" class="form-control" id="cheque-name" name="cheque-name" placeholder="Name" disabled>
                            </div>
                        </div>
                    </div>
                    <!-- paypal -->
                    <div class="row payment-method" id="payment-paypal">
                        <div class="col-md-12">
                             <div class="form-group">
                                <label for="paypal-email">PayPal Email Address</label>
                                <input type="text" class="form-control" id="paypal-email" name="paypal-email" placeholder="PayPal Email" disabled>
                            </div>
                        </div>
                    </div>
                    <!-- bitcoin -->
                    <div class="row payment-method" id="payment-bitcoin">
                        <div class="col-md-12">
                             <div class="form-group">
                                <label for="bitcoin-address">Bitcoin Address</label>
                                <input type="text" class="form-control" id="bitcoin-address" name="bitcoin-address" placeholder="Bitcoin Address" disabled>
                            </div>
                        </div>
                    </div>
                    <!-- address -->
                    <div class="row">
						<div class="col-md-12">
							<div class="form-group">
							<label for="Address">Address</label>
							<textarea class="form-control" rows="4" name="address" id="address" placeholder="Address" disabled></textarea>
							</div>
						</div>
                    </div>
                    <div class="row">
						<div class="col-md-12">
							<div class="form-group">
							<label for="voucher">Voucher Code (Optional)</label>
							<input type="text" class="form-control" name="voucher" id="voucher" placeholder="Voucher Code" disabled />
							</div>
						</div>
                    </div>
                </div>
                <p>
                    <input type="hidden" name="myprice" id="myprice" value="0"/>
                    <button type="submit" class="btn btn-primary btn-md btn-gecko submitform" disabled>Register Sale</button>
                    <button type="reset" class="btn btn-default btn-md" disabled>Reset</button>
					<a style="font-size: 12px;" href="/terms"target="_blank">You agree to the Terms & Conditions</a>
                    <span class="processing">...</span>
                </p>
				<p style="padding: 0px 10px; margin-top: 15px;">
					<h4>What happens after I register my sale?</h4>
					<ul><h5 style="line-height: 18px;">
<li>We will give you a pre-paid tracked 1st Class postage label and instructions on sending your {{ $product->name }} to us.</li></h5>
                                        <h5 style="line-height: 18px;"><li>We will send Sell Order status updates via email/SMS.</li></h5>
					<h5 style="line-height: 18px;"><li>We will send payment the same day we receive your {{ $product->name }}.</li></h5>
                                      </ul>
				</p>
            </form>
        </div>
    </div>
</div>
</div>



<script type="text/javascript">
    function new_order(model_id) {
        $.order = {};
        $.order.product = '{{ $product->id }}';
        $.order.model = model_id;
        $.order.properties = {};
        
        $.model = {};
        $.model.baseprice = $('#model-' + model_id).data('baseprice');
        $.model.minprice = $('#model-' + model_id).data('minprice');
       
    }
</script>
@stop