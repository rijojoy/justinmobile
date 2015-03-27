@extends('layouts.admin.admin')

@section('breadcrumbs')
    <?php $breadcrumbs = array(
        ['icon' => 'truck', 'label' => 'Orders', 'url' => 'orders'],
        ['icon' => 'envelope', 'label' => 'Templates', 'url' => 'orders/templates'],
        ['icon' => 'plus', 'label' => 'New Template', 'url' => 'orders/templates/create']
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
                {{ Form::open(array('url' => 'admin/orders/templates', 'class' => 'form-horizontal fill-up')) }}
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
                                    {{ Form::button('Create Template', array('type' => 'submit', 'class' => 'btn btn-blue')) }}
                                    {{ Form::button('Reset', array('class' => 'btn btn-default', 'type' => 'reset')) }}
                                </div>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop