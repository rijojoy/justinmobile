@extends('layouts.admin.admin')

@section('breadcrumbs')
    <?php $breadcrumbs = array(
        ['icon' => 'truck', 'label' => 'Orders', 'url' => 'orders'],
        ['icon' => 'truck', 'label' => '#' . $order->id . ' (' . $order->created_at->diffForHumans() . ')', 'url' => 'orders/' . $order->id],
        ['icon' => 'pencil', 'label' => 'edit', 'url' => "orders/{$order->id}/edit"]
    ); ?>
    @include('admin._bits.breadcrumb', $breadcrumbs)
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <span class="title">Edit Order</span>
            </div>
            <div class="box-content">
                {{ Form::open(array('url' => 'admin/orders/' . $order->id, 'method' => 'put', 'class' => 'form-horizontal fill-up')) }}
                    <div class="row">
                        <div class="col-lg-6">
                            <ul class="padded separate-sections">
                                
                                @if($errors->count() > 0)
                                <div class="alert alert-danger form-notice">
                                    @foreach($errors->all() as $message)
                                    {{$message}}
                                    @endforeach
                                </div>
                                @endif
                                
                                <?php 
                                $values = array_merge(json_decode($order->personal_info, true), array('imei' => $order->imei)); 
                                $fields = array(
                                    'name' => ['label' => 'Name', 'type' => 'text'],
                                    'email' => ['type' => 'text', 'label' => 'Email'],
                                    'address' => ['type' => 'textarea', 'label' => 'Address'],
                                    'phone' => ['type' => 'text', 'label' => 'Phone'],
                                    'payment' => ['type' => 'select', 'label' => 'Payment Type', 'values' => ['bank' => 'Bank', 'paypal' => 'Paypal', 'cheque' => 'Cheque']],
                                    'bank-accountnumber' => ['type' => 'text', 'label' => 'Bank Account'],
                                    'bank-sortcode' => ['type' => 'text', 'label' => 'Bank Sort Code'],
                                    'paypal-email' => ['type' => 'text', 'label' => 'Paypal Email'],
                                    'cheque-name' => ['type' => 'text', 'label' => 'Cheque Name'],
                                    'myprice' => ['type' => 'text', 'label' => 'Price'],
                                    'device-network' => ['type' => 'select', 'label' => 'Device Network', 'values' => ['unknown' => 'Unknown', 'o2' => 'O2', 'vodafone' => 'Vodafone', 'three' => 'Three', 'orange' => 'Orange', 'unlocked' => 'Unlocked']],
                                    'packaging' => ['type' => 'select', 'label' => 'Packaging', 'values' => ['provide' => 'Provide Pre-paid packaging (Free)', 'post' => 'I\'ll post the item to you myself (Faster)']],
                                    'imei' => ['type' => 'text', 'label' => 'IMEI']
                                );
                                ?>
                                @foreach ($fields as $key => $properties)
                                <?php $properties['value'] = isset($values[$key]) ? $values[$key] : ''; ?>
                                <div class="form-group">
                                    <label class="control-label col-lg-2">{{ $properties['label'] }}</label>
                                    <div class="col-lg-10">
                                        <?php if($properties['type'] == 'text') { ?>
                                        {{ Form::text($key, $properties['value'], array('placeholder' => $properties['label'])) }}
                                        <?php } else if ($properties['type'] == 'select') { ?>
                                        {{ Form::select($key, $properties['values'], $properties['value'], array('class' => 'uniform')) }}
                                        <?php } else if ($properties['type'] == 'textarea') { ?>
                                        {{ Form::textarea($key, $properties['value'], array('placeholder' => $properties['label'], 'rows' => '5')) }}
                                        <?php } ?>
                                    </div>
                                </div>
                                @endforeach
                                <div class="form-actions">
                                    {{ Form::button('Update Order', array('type' => 'submit', 'class' => 'btn btn-blue')) }}
                                </div>
                            </ul>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@stop