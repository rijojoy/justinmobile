@extends('layouts.admin.admin')

@section('breadcrumbs')
    <?php $breadcrumbs = array(
        ['icon' => 'mobile-phone', 'label' => 'Products', 'url' => 'products'],
        ['icon' => 'mobile-phone', 'label' => $product->name, 'url' => 'products/' . $product->id],
        ['icon' => 'mobile-phone', 'label' => $model->name, 'url' => 'products/' . $product->id . '/models/' . $model->id],
        ['icon' => 'lightbulb', 'label' => $property->name, 'url' => "products/{$product->id}/models/{$model->id}/properties/{$property->id}"]
    ); ?>
    @include('admin._bits.breadcrumb', $breadcrumbs)
@stop

@section('content')
<div class="action-nav-normal action-nav-line">
    <div class="row action-nav-row">
        <div class="col-sm-2 action-nav-button">
            <a href= "{{ url() }}/admin/products/{{ $product->id }}/models/{{ $model->id }}/properties/{{ $property->id }}/edit" title="Edit Property">
                <i class="icon-lightbulb"></i>
                <span>Edit Property</span>
            </a>
            <span class="triangle-button green"><i class="icon-edit"></i></span>
        </div>
        <div class="col-sm-2 action-nav-button">
            <a href= "{{ url() }}/admin/products/{{ $product->id }}/models/{{ $model->id }}/properties/{{ $property->id }}/options/create" title="New Option">
                <i class="icon-tag"></i>
                <span>New Option</span>
            </a>
            <span class="triangle-button green"><i class="icon-plus"></i></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <span class="title"><i class="icon-mobile-phone"></i> {{ $property->name }}</span>
            </div>
            <div class="box-content padded">
                Property {{ $property->name }} has {{ count($options) }} options.
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header"><span class="title">Options</span></div>
            <div class="box-content">
                <div id="dataTables" class="dTable-no-header">
                    <table cellpadding="0" cellspacing="0" border="0" class="dTable responsive">
                        <thead>
                            <tr>
                                <th><div>Position (order)</div></th>
                                <th><div>Name</div></th>
                                <th><div>Modifier</div></th>
                                <th><div>Options</div></th>
                            </tr>
                        </thead>
                            @foreach ($options as $option)
                            <tr>
                                <td>{{ $option->order_pos }}</td>
                                <td>{{ $option->name }}</td>
                                <?php 
                                    $sign = (in_array($option->modifier_type, array('add_percentage', 'add_amount'))) ? '+' : '-';
                                    $amount = (in_array($option->modifier_type, array('add_percentage', 'deduct_percentage'))) ? $option->modifier_amount . '%' : '£' . $option->modifier_amount;
                                ?>
                                <td>{{ $sign }}{{ $amount }}</td>
                                <td>
                                    <a href= "{{ url() }}/admin/products/{{ $product->id }}/models/{{ $model->id }}/properties/{{ $property->id }}/options/{{ $option->id }}/edit" class="btn btn-sm btn-default"><i class="icon-file"></i> Edit</a>
                                    {{ Form::open(array('url' => '/admin/products/' . $product->id . '/models/' . $model->id . '/properties/' . $property->id . '/options/' . $option->id, 'method' => 'delete', 'class' => 'table-form')) }}
                                        {{ Form::button('<i class="icon-trash"></i> Delete', array('type' => 'submit', 'class' => 'btn btn-sm btn-red form-confirm', 'data-confirm' => 'Are you sure you want to delete this model and all properties permanently?')) }}
                                    {{ Form::close(); }}
                                </td>
                            </tr>
                            @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop