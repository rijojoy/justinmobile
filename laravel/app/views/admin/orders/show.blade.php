@extends('layouts.admin.admin')

@section('breadcrumbs')
    <?php $breadcrumbs = array(
        ['icon' => 'truck', 'label' => 'Orders', 'url' => 'orders'],
        ['icon' => 'truck', 'label' => '#' . $order->id . ' (' . $order->created_at->diffForHumans() . ')', 'url' => 'orders/' . $order->id]
    ); ?>
    @include('admin._bits.breadcrumb', $breadcrumbs)
@stop

<?php

$product_cache = json_decode($order->product_cache, true);
$model_cache = json_decode($order->model_cache, true);
$properties_cache = json_decode($order->properties_cache, true);
$options_cache = json_decode($order->options_cache, true);
$order_info = json_decode($order->order_info, true);
$personal_info = json_decode($order->personal_info);

?>

@section('content')
<div class="action-nav-normal action-nav-line">
    <div class="row action-nav-row">
        <div class="col-sm-2 action-nav-button">
            <a href= "{{ url() }}/admin/orders/{{ $order->id }}/edit" title="Edit Order">
                <i class="icon-edit"></i>
                <span>Edit Order</span>
            </a>
            <span class="triangle-button green"><i class="icon-edit"></i></span>
        </div>
        <div class="col-sm-2 action-nav-button">
            <a href= "{{ url() }}/admin/orders/{{ $order->id }}/notes/create" title="New Note">
                <i class="icon-envelope"></i>
                <span>Update Order</span>
            </a>
            <span class="triangle-button green"><i class="icon-plus"></i></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="box">
            <div class="box-header">
                <span class="title">{{ $personal_info->name }} <span class="btn btn-sm btn-{{ $order->status->class}}">{{ $order->status->name }}</span></span>
            </div>
            <div class="box-content padded order-data">
                <div id="dataTables" class="dTable-no-header">
                    <table cellpadding="0" cellspacing="0" border="0" class="dTable responsive">
                        <thead>
                            <tr>
                                <th><div>Field</div></th>
                                <th><div>Value</div></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $values = array_merge(json_decode($order->personal_info, true), array('imei' => $order->imei)); 
                            $fields = array(
                                'name' => ['label' => 'Name', 'type' => 'text'],
                                'email' => ['type' => 'text', 'label' => 'Email'],
                                'address' => ['type' => 'textarea', 'label' => 'Address'],
                                'phone' => ['type' => 'text', 'label' => 'Phone'],
                                'payment' => ['type' => 'select', 'label' => 'Payment Type', 'values' => ['bank' => 'Bank', 'paypal' => 'PayPal', 'cheque' => 'Cheque', 'bitcoin' => 'Bitcoin']],
                                'bank-accountnumber' => ['type' => 'text', 'label' => 'Bank Account'],
                                'bank-sortcode' => ['type' => 'text', 'label' => 'Bank Sort Code'],
                                'cheque-name' => ['type' => 'text', 'label' => 'Cheque Name'],
                                'paypal-email' => ['type' => 'text', 'label' => 'Paypal Email'],
                                'bitcoin-address' => ['type' => 'text', 'label' => 'Bitcoin Address'],
                                'myprice' => ['type' => 'text', 'label' => 'Price'],
                                'device-network' => ['type' => 'text', 'label' => 'Device Network', 'values' => ['unknown' => 'Unknown', 'o2' => 'O2', 'vodafone' => 'Vodafone', 'three' => 'Three', 'orange' => 'Orange', 'unlocked' => 'Unlocked']],
                                'packaging' => ['type' => 'select', 'label' => 'Packaging', 'values' => ['provide' => 'Provide Pre-paid packaging (Free)', 'post' => 'I\'ll post the item to you myself (Faster)']],
                                'imei' => ['type' => 'text', 'label' => 'IMEI'],
								'voucher' => ['type' => 'text', 'label' => 'Voucher'],
                            );
                            ?>
                            @foreach ($fields as $key => $propertiess) 
                            <?php $propertiess['value'] = isset($values[$key]) ? $values[$key] : ''; if(!empty($propertiess['value'])) { ?>
                            <tr>
                                <td>{{ $propertiess['label'] }}</td>
                                @if (isset($propertiess['values']))
                                <td>{{ nl2br($propertiess['values'][$propertiess['value']]) }}</td>
                                @else
                                <td>{{ nl2br($propertiess['value']) }}</td>
                                @endif
                            </tr>
                            <?php } ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box">
            <div class="box-header">
                <span class="title">Product Specification</span>
            </div>
            <div class="box-content padded order-data">
                <div id="dataTables" class="dTable-no-header">
                    <table cellpadding="0" cellspacing="0" border="0" class="dTable responsive">
                        <thead>
                            <tr>
                                <th><div>Field</div></th>
                                <th><div>Value</div></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $properties[] = array(
                                'name' => $product_cache['name'],
                                'value' => $model_cache['name'],
                                'explanation' => false,
                                'price' => '+£' . $model_cache['base_price'],
                                'class' => 'productctc',
                            );
                            
                            foreach ($order_info['properties'] as $property_id => $option_id) { 
                                $property = $properties_cache[$property_id];
                                $name = $property['name'];
                                $price_additions = array();
                                
                                if (is_array($option_id)) {
                                    $value = '';
                                    foreach ($option_id as $option) {
                                        $value .= $options_cache[$option]['name'] .'<br/>';
                                        // price additions
                                        $price_additions[] = array(
                                            'modifier_amount' =>  $options_cache[$option]['modifier_amount'],
                                            'modifier_type' =>  $options_cache[$option]['modifier_type'],
                                            'name' =>  $options_cache[$option]['name']
                                        );
                                    }
                                } else {
                                    $value = $options_cache[$option_id]['name'];
                                    
                                    // price addition
                                    $price_additions[] = array(
                                        'modifier_amount' =>  $options_cache[$option_id]['modifier_amount'],
                                        'modifier_type' =>  $options_cache[$option_id]['modifier_type'],
                                        'name' =>  $options_cache[$option_id]['name']
                                    );
                                }
                                
                                $price_types = array(
                                    'add_amount' => ['sign' => '£', 'action' => '+'],
                                    'add_percentage' => ['sign' => '%', 'action' => '+'],
                                    'deduct_amount' => ['sign' => '£', 'action' => '-'],
                                    'deduct_percentage' => ['sign' => '%', 'action' => '-']
                                );
                                
                                $price = '';
                                foreach ($price_additions as $addition) {
                                    $price .= $price_types[$addition['modifier_type']]['action'] . $price_types[$addition['modifier_type']]['sign'] . number_format($addition['modifier_amount'], 2) .'<br/>';
                                }
                                
                                if (isset($explanations[$property_id])) {
                                    $explanation = $explanations[$property_id];
                                }
                                
                                $explanation = (isset($order_info['explanations'][$property_id])) ? $order_info['explanations'][$property_id] : false;
                                
                                $properties[] = array(
                                    'name' => $name,
                                    'value' => $value,
                                    'explanation' => $explanation,
                                    'price' => $price,
                                );
                            } ?>
                            @foreach ($properties as $property) 
                            <tr<?php if(isset($property['class'])) { ?> class="{{ $property['class'] }}"<?php } ?>>
                                <td class="ffffffff">{{ $property['name'] }}</td>
                                <td class="ffffffff">{{ $property['value'] }}</td>
                                <td class="ffffffff">{{ $property['price'] }}</td>
                                <td class="ffffffff">{{ $property['explanation'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        @foreach ($order->notes()->orderBy('created_at', 'desc')->get() as $note)
        <ul class="chat-box timeline">
            <li class="arrow-box-left gray">
                <div class="avatar"><img class="avatar-small" src="/assets/images/avatars/{{ $note->user->id }}.jpg" /></div>
                <div class="info">
                    <span class="name">
                        <span class="btn btn-xs btn-{{ $note->status->class}}">{{ $note->status->name }}</span> <strong class="indent">{{ $note->user->first_name }} {{ $note->user->last_name }}</strong> {{ $note->byline }}
                    </span>
                    <span class="time" title="{{ $note->created_at }}"><i class="icon-time"></i> {{ $note->created_at->diffForHumans() }}</span>
                </div>
                @if ($note->body)
                <div class="content">
                    <blockquote>{{ nl2br($note->body) }}</blockquote>
                    @if ($note->send_email == 1)
                    <div>
                        <i class="icon-envelope"></i> sent as an email to {{ $personal_info->email }}
                    </div>
                    @endif
                </div>
                @endif
            </li>
        </ul>
        @endforeach
    </div>
</div>
@stop