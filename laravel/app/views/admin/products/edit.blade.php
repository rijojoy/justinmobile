@extends('layouts.admin.admin')

@section('breadcrumbs')
    <?php $breadcrumbs = array(
        ['icon' => 'mobile-phone', 'label' => 'Products', 'url' => 'products'],
        ['icon' => 'mobile-phone', 'label' => "{$product->name}", 'url' => "products/{$product->id}"],
        ['icon' => 'edit', 'label' => "Edit", 'url' => "products/{$product->id}/edit"],
    ); ?>
    @include('admin._bits.breadcrumb', $breadcrumbs)
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <span class="title">Edit {{ $product->name }}</span>
            </div>
            <div class="box-content">
                {{ Form::model($product, array('url' => 'admin/products/' . $product->id, 'method' => 'put', 'class' => 'form-horizontal fill-up')) }}
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
                                        <span class="help-block">Displayed on product page &mdash; Required, between 1 and 128 characters</span>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-lg-2">Slug</label>
                                    <div class="col-lg-10">
                                        {{ Form::text('slug') }}
                                        <span class="help-block">Used in the URL, eg: sell/ipad &mdash; Required, between 1 and 64 characters</span>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-lg-2">Logo</label>
                                    <div class="col-lg-10">
                                        {{ Form::text('logo') }}
                                        <span class="help-block">Logo for the page, should be located in /assets/images/logo/. Eg: "iphone.png" &mdash; Optional</span>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-lg-2">Default Product</label>
                                    <div class="col-lg-10">
                                        {{ Form::checkbox('default', 0, null, array('id' => 'default', 'class' => 'icheck')) }}
                                        <label for="default">Default product (use on homepage)</label>
                                    </div>
                                </div>
                                
                                <div class="form-actions">
                                    {{ Form::button('Update Product', array('type' => 'submit', 'class' => 'btn btn-blue')) }}
                                </div>
                            </ul>
                        </div>
                    </div>
                {{ Form::close() }}
                <div class="row">
                    <div class="col-lg-6">
                        <ul class="padded separate-sections">
                            {{ Form::open(array('url' => '/admin/products/' . $product->id, 'method' => 'delete', 'class' => 'table-form')) }}
                            <div class="form-actions">
                                {{ Form::button('<i class="icon-trash"></i> Delete', array('type' => 'submit', 'class' => 'btn btn-sm btn-red form-confirm', 'data-confirm' => 'Are you sure you want to delete this product permanently?')) }}
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