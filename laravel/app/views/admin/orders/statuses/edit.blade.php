@extends('layouts.admin.admin')

@section('breadcrumbs')
    <?php $breadcrumbs = array(
        ['icon' => 'truck', 'label' => 'Orders', 'url' => 'orders'],
        ['icon' => 'lemon', 'label' => 'Statuses', 'url' => 'orders/statuses'],
        ['icon' => 'lemon', 'label' => $status->name, 'url' => 'orders/statuses/' . $status->id],
        ['icon' => 'edit', 'label' => 'Edit', 'url' => "orders/statuses/{$status->id}/edit"]
    ); ?>
    @include('admin._bits.breadcrumb', $breadcrumbs)
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <span class="title">Edit Status</span>
            </div>
            <div class="box-content">
                {{ Form::model($status, array('url' => 'admin/orders/statuses/' . $status->id, 'method' => 'put', 'class' => 'form-horizontal fill-up')) }}
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
                                    <label class="control-label col-lg-2">Class</label>
                                    <div class="col-lg-10">
                                        {{ Form::text('class', null, array('id' => 'class')) }}
                                        <span class="help-block">From list below (click to select) or add new "btn.btn-{name}" in assets/admin.statuses.css &mdash; Required</span>
                                    </div>
                                </div>
                                
                                <?php
                                $css_app = file_get_contents(public_path() . '/assets/css/application.css');
                                $css_custom = file_get_contents(public_path() . '/assets/css/admin.statuses.css');
                                preg_match_all('%btn.btn-([a-zA-Z]{3,100}) %', $css_app . $css_custom, $button_classes);
                                $classes = array_slice($button_classes[1], 3);
                                ?>
                                
                                <div class="form-group">
                                    <label class="control-label col-lg-2">Available Classes</label>
                                    <div class="col-lg-10">
                                        <span class="help-block status-available-list">
                                            <?php foreach ($classes as $class) { ?>
                                            <span class="btn btn-sm btn-{{ $class }}" data-class="{{ $class }}">{{ $class }}</span>
                                            <?php } ?>
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="form-actions">
                                    {{ Form::button('Update Status', array('type' => 'submit', 'class' => 'btn btn-blue')) }}
                                </div>
                            </ul>
                        </div>
                    </div>
                {{ Form::close() }}
                <div class="row">
                    <div class="col-lg-6">
                        <ul class="padded separate-sections">
                            {{ Form::open(array('url' => '/admin/orders/statuses/' . $status->id, 'method' => 'delete', 'class' => 'table-form')) }}
                            <div class="form-actions">
                                {{ Form::button('<i class="icon-trash"></i> Delete', array('type' => 'submit', 'class' => 'btn btn-sm btn-red form-confirm', 'data-confirm' => 'Are you sure you want to delete this status permanently?')) }}
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