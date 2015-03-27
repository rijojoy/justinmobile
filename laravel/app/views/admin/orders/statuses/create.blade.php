@extends('layouts.admin.admin')

@section('breadcrumbs')
    <?php $breadcrumbs = array(
        ['icon' => 'truck', 'label' => 'Orders', 'url' => 'orders'],
        ['icon' => 'lemon', 'label' => 'Statuses', 'url' => 'orders/statuses'],
        ['icon' => 'plus', 'label' => 'New Status', 'url' => 'orders/statuses/create']
    ); ?>
    @include('admin._bits.breadcrumb', $breadcrumbs)
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <span class="title">Create New Status</span>
            </div>
            <div class="box-content">
                {{ Form::open(array('url' => 'admin/orders/statuses', 'class' => 'form-horizontal fill-up')) }}
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
                                        <span class="help-block">The name of the status used internally &mdash; Required, between 1 and 128 characters</span>
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
                                    {{ Form::button('Create Status', array('type' => 'submit', 'class' => 'btn btn-blue')) }}
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