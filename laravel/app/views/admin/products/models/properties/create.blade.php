@extends('layouts.admin.admin')

@section('breadcrumbs')
    <?php $breadcrumbs = array(
        ['icon' => 'mobile-phone', 'label' => 'Products', 'url' => 'products'],
        ['icon' => 'mobile-phone', 'label' => $product->name, 'url' => 'products/' . $product->id],
        ['icon' => 'mobile-phone', 'label' => $model->name, 'url' => 'products/' . $product->id . '/models/' . $model->id],
        ['icon' => 'lightbulb', 'label' => 'New Property', 'url' => "products/{$product->id}/models/{$model->id}/properties/create"]
    ); ?>
    @include('admin._bits.breadcrumb', $breadcrumbs)
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <span class="title">Create New Property</span>
            </div>
            <div class="box-content">
                {{ Form::open(array('url' => '/admin/products/' . $product->id . '/models/' . $model->id . '/properties', 'class' => 'form-horizontal fill-up', 'files' => true)) }}
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
                                        <span class="help-block">Displayed internally &mdash; Required, between 1 and 128 characters</span>
                                    </div>
                                </div>
                            
                                <div class="form-group">
                                    <label class="control-label col-lg-2">Title</label>
                                    <div class="col-lg-10">
                                        {{ Form::text('title') }}
                                        <span class="help-block">Displayed in the property list &mdash; Required, between 1 and 128 characters</span>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-lg-2">Help Text</label>
                                    <div class="col-lg-10">
                                        {{ Form::textarea('help_text', null, array('rows' => 3)) }}
                                        <span class="help-block">If set, the help text icon will show <i class="icon-info-sign"></i> (clicking loads modal) &mdash; Optional, HTML supported</span>
                                    </div>
                                </div>
								
                                <div class="form-group">
                                    <label class="control-label col-lg-2">Explanation Name</label>
                                    <div class="col-lg-10">
                                        {{ Form::text('explanation_name') }}
                                        <span class="help-block">Displayed in the "explanation" modal title</span>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-lg-2">Explanation Description</label>
                                    <div class="col-lg-10">
                                        {{ Form::textarea('explanation_description', null, array('rows' => 3)) }}
                                        <span class="help-block">Placeholder value for the "explanation" modal textarea</span>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-lg-2">Type</label>
                                    <div class="col-lg-10">
                                        {{ Form::select('type', array('single' => 'Single', 'multi' => 'Multiple'), 'single', array('class' => 'uniform')) }}
                                        <span class="help-block">Single = only one option can selected (eg: size), multiple = toggle (eg: accesories) &mdash; Required</span>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-lg-2">Required</label>
                                    <div class="col-lg-10">
                                        {{ Form::checkbox('required', 0, null, array('id' => 'required', 'class' => 'icheck')) }}
                                        <label for="required">Require user to fill in this property (if not set, user can skip)</label>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-lg-2">Order</label>
                                    <div class="col-lg-10">
                                        {{ Form::text('order', '0') }}
                                        <span class="help-block">Options are ordered by this in ascending order (eg: 0 = top, 1 = second) &mdash; Required</span>
                                    </div>
                                </div>
                                
                                <div class="form-actions">
                                    {{ Form::button('Create Property', array('type' => 'submit', 'class' => 'btn btn-blue')) }}
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