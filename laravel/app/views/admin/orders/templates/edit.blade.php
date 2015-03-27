@extends('layouts.admin.admin')

@section('breadcrumbs')
    <?php $breadcrumbs = array(
        ['icon' => 'truck', 'label' => 'Orders', 'url' => 'orders'],
        ['icon' => 'envelope', 'label' => 'Templates', 'url' => 'orders/templates'],
        ['icon' => 'envelope', 'label' => $template->name, 'url' => 'orders/templates/' . $template->id],
        ['icon' => 'edit', 'label' => 'Edit', 'url' => "/orders/templates/{$template->id}/edit"]
    ); ?>
    @include('admin._bits.breadcrumb', $breadcrumbs)
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <span class="title">Create New Template</span>
            </div>
            <div class="box-content">
                {{ Form::model($template, array('url' => 'admin/orders/templates/' . $template->id, 'method' => 'put', 'class' => 'form-horizontal fill-up')) }}
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
                                    <label class="control-label col-lg-2">Name</label>
                                    <div class="col-lg-10">
                                        {{ Form::text('name') }}
                                        <span class="help-block">Required, between 1 and 128 characters</span>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-lg-2">Status</label>
                                    <div class="col-lg-10">
                                        {{ Form::select('status_id', $statuses, null, array('class' => 'uniform')) }}
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-lg-2">Body</label>
                                    <div class="col-lg-10">
                                        {{ Form::textarea('body', null, array('rows' => 4)) }}
                                        <span class="help-block">Required</span>
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
                                    {{ Form::button('Update Template', array('type' => 'submit', 'class' => 'btn btn-blue')) }}
                                </div>
                            </ul>
                        </div>
                    </div>
                {{ Form::close() }}
                <div class="row">
                    <div class="col-lg-6">
                        <ul class="padded separate-sections">
                            {{ Form::open(array('url' => '/admin/orders/templates/' . $template->id, 'method' => 'delete', 'class' => 'table-form')) }}
                            <div class="form-actions">
                                {{ Form::button('<i class="icon-trash"></i> Delete', array('type' => 'submit', 'class' => 'btn btn-sm btn-red form-confirm', 'data-confirm' => 'Are you sure you want to delete this template permanently?')) }}
                            </div>
                            {{ Form::close() }}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop