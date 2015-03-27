@extends('layouts.admin.admin')

@section('breadcrumbs')
    <?php $breadcrumbs = array(
        ['icon' => 'mobile-phone', 'label' => 'Products', 'url' => 'products'],
        ['icon' => 'mobile-phone', 'label' => $product->name, 'url' => 'products/' . $product->id],
        ['icon' => 'mobile-phone', 'label' => $model->name, 'url' => 'products/' . $product->id . '/models/' . $model->id],
        ['icon' => 'lightbulb', 'label' => $property->name, 'url' => "products/{$product->id}/models/{$model->id}/properties/{$property->id}"],
        ['icon' => 'tag', 'label' => 'New Option', 'url' => "products/{$product->id}/models/{$model->id}/properties/{$property->id}/options/create"]
    ); ?>
    @include('admin._bits.breadcrumb', $breadcrumbs)
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <span class="title">Edit Option</span>
            </div>
            <div class="box-content">
                {{ Form::open(array('url' => '/admin/products/' . $product->id . '/models/' . $model->id . '/properties/' . $property->id . '/options', 'class' => 'form-horizontal fill-up', 'files' => true)) }}
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
                                        <span class="help-block">Displayed on the order form as the option key &mdash; Required, between 1 and 128 characters</span>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-lg-2">Modifier</label>
                                    <div class="col-lg-10">
                                        {{ Form::text('modifier_amount') }}
                                        <span class="help-block">Amount of the price change (Enter 0 if no change is required) &mdash; Required, numeric</span>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-lg-2">Type</label>
                                    <div class="col-lg-10">
                                        {{ Form::select('modifier_type', array('add_percentage' => 'Add Percentage', 'deduct_percentage' => 'Deduct Percentage', 'add_amount' => 'Add Amount', 'deduct_amount' => 'Deduct Amount'), 'add_amount', array('class' => 'uniform')) }}
                                        <span class="help-block">Way in which the amount will affect the price &mdash; Required</span>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-lg-2">Explanation</label>
                                    <div class="col-lg-10">
                                        {{ Form::checkbox('explanation', 0, null, array('id' => 'explanation', 'class' => 'icheck')) }}
                                        <label for="explanation">Ask user to explain selection</label>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-lg-2">Order</label>
                                    <div class="col-lg-10">
                                        {{ Form::text('order_pos', '0') }}
                                        <span class="help-block">Options are ordered by this in ascending order (eg: 0 = top, 1 = second) &mdash; Required</span>
                                    </div>
                                </div>
                                
                                <div class="form-actions">
                                    {{ Form::button('Create Option', array('type' => 'submit', 'class' => 'btn btn-blue')) }}
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