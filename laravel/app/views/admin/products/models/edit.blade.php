@extends('layouts.admin.admin')

@section('breadcrumbs')
    <?php $breadcrumbs = array(
        ['icon' => 'mobile-phone', 'label' => 'Products', 'url' => 'products'],
        ['icon' => 'mobile-phone', 'label' => $product->name, 'url' => 'products/' . $product->id],
        ['icon' => 'mobile-phone', 'label' => $model->name, 'url' => "products/{$product->id}/models/{$model->id}"],
        ['icon' => 'mobile-phone', 'label' => 'Edit', 'url' => "products/{$product->id}/models/{$model->id}/edit"],
    ); ?>
    @include('admin._bits.breadcrumb', $breadcrumbs)
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <span class="title">Edit Model</span>
            </div>
            <div class="box-content">
                {{ Form::model($model, array('url' => 'admin/products/' . $product->id . '/models/' . $model->id, 'method' => 'put', 'class' => 'form-horizontal fill-up', 'files' => true)) }}
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
                                        <span class="help-block">Displayed on the product page &mdash; Required, between 1 and 128 characters</span>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-lg-2">Description</label>
                                    <div class="col-lg-10">
                                        {{ Form::text('description') }}
                                        <span class="help-block">Optional, between 1 and 256 characters</span>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-lg-2">Image</label>
                                    <div class="col-lg-10">
                                        {{ Form::file('image') }}
                                        <span class="help-block">Optional, new image will replace old. Displayed at 260 x 230. Must be .png.</span>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-lg-2">Base Price</label>
                                    <div class="col-lg-10">
                                        {{ Form::text('base_price') }}
                                        <span class="help-block">Price of the model (before properties are selected) &mdash; Required, decimal (eg: 400.00)</span>
                                    </div>
                                </div>
                                <!-- Added By Rijo Joy -->
                                <div class="form-group">
                                    <label class="control-label col-lg-2">Minimum Price</label>
                                    <div class="col-lg-10">
                                        {{ Form::text('min_price') }}
                                        <span class="help-block">Enter the minimum price here</span>
                                    </div>
                                </div>
                                <!-- End of Added By Rijo Joy -->
                                
                                <div class="form-actions">
                                    {{ Form::button('Update Model', array('type' => 'submit', 'class' => 'btn btn-blue')) }}
                                </div>
                            </ul>
                        </div>
                    </div>
                {{ Form::close() }}
                <div class="row">
                    <div class="col-lg-6">
                        <ul class="padded separate-sections">
                            {{ Form::open(array('url' => '/admin/products/' . $product->id . '/models/' . $model->id, 'method' => 'delete', 'class' => 'table-form')) }}
                            <div class="form-actions">
                                {{ Form::button('<i class="icon-trash"></i> Delete', array('type' => 'submit', 'class' => 'btn btn-sm btn-red form-confirm', 'data-confirm' => 'Are you sure you want to delete this model and all properties permanently?')) }}
                            </div>
                            {{ Form::close(); }}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop