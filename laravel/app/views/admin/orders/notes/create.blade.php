@extends('layouts.admin.admin')

@section('breadcrumbs')
    <?php $breadcrumbs = array(
        ['icon' => 'truck', 'label' => 'Orders', 'url' => 'orders'],
        ['icon' => 'truck', 'label' => $order->id, 'url' => 'orders/' . $order->id],
        ['icon' => 'plus', 'label' => 'New Note', 'url' => 'orders/'.$order->id.'/notes/create']
    ); ?>
    @include('admin._bits.breadcrumb', $breadcrumbs)
@stop

@section('content')
<input type="hidden" id="current_url" value="<?php echo Request::url(); ?>"></input>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <span class="title">Create New Note</span>
            </div>
            <div class="box-content">
                <?php if($template) { ?>
                    {{ Form::model($template, array('url' => 'admin/orders/' . $order->id . '/notes', 'class' => 'form-horizontal fill-up')) }}
                <?php } else { ?>
                    {{ Form::open(array('url' => 'admin/orders/' . $order->id . '/notes', 'class' => 'form-horizontal fill-up')) }}
                <?php } ?>
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
                                
                                <div class="form-group">
                                    <label class="control-label col-lg-2">Load Template</label>
                                    <div class="col-lg-10">
                                        {{ Form::select('template_id', $templates, null, array('class' => 'uniform', 'id' => 'template_switch')) }}
                                    </div>
                                </div>
                                <hr>
                                
                                <div class="form-group">
                                    <label class="control-label col-lg-2">Status</label>
                                    <div class="col-lg-10">
                                        {{ Form::select('status_id', $statuses, null, array('class' => 'uniform')) }}
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-lg-2">Body</label>
                                    <div class="col-lg-10">
                                        <?php 
                                        $personal_info = json_decode($order->personal_info);
                                        $body = Form::textarea('body', null, array('rows' => 8));
                                        $search = ['%%name%%', '%%email%%']; // lowercase
                                        $replace = [$personal_info->name, $personal_info->email];
                                        $body = str_replace($search, $replace, $body);
                                        echo $body;
                                        ?>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-lg-2">Email</label>
                                    <div class="col-lg-10">
                                        {{ Form::checkbox('send_email', 0, null, array('id' => 'send_email', 'class' => 'icheck')) }}
                                        <label for="send_email">Send as a message to the customer</label>
                                    </div>
                                </div>
                                
                                <div class="form-actions">
                                    {{ Form::button('Add Note', array('type' => 'submit', 'class' => 'btn btn-blue')) }}
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