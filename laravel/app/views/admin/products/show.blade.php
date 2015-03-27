@extends('layouts.admin.admin')

@section('breadcrumbs')
    <?php $breadcrumbs = array(
        ['icon' => 'mobile-phone', 'label' => 'Products', 'url' => 'products'],
        ['icon' => 'mobile-phone', 'label' => $product->name, 'url' => 'products/' . $product->id]
    ); ?>
    @include('admin._bits.breadcrumb', $breadcrumbs)
@stop

@section('content')
<div class="action-nav-normal action-nav-line">
    <div class="row action-nav-row">
        <div class="col-sm-2 action-nav-button">
            <a href= "{{ url() }}/admin/products/{{ $product->id }}/edit" title="Edit Product">
                <i class="icon-edit"></i>
                <span>Edit Product</span>
            </a>
            <span class="triangle-button green"><i class="icon-edit"></i></span>
        </div>
        <div class="col-sm-2 action-nav-button">
            <a href= "{{ url() }}/admin/products/{{ $product->id }}/models/create" title="New Model">
                <i class="icon-mobile-phone"></i>
                <span>New Model</span>
            </a>
            <span class="triangle-button green"><i class="icon-plus"></i></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <span class="title"><i class="icon-mobile-phone"></i> {{ $product->name }} @if ($product->default == 1) <span class="label label-green">Default Product</span> @endif</span>
            </div>
            <div class="box-content padded">
                Product slug is <strong>{{ $product->slug }}</strong>, there are {{ count($product->models) }} model(s) available for this product.
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header"><span class="title">Models</span></div>
            <div class="box-content">
                <div id="dataTables" class="dTable-no-header">
                    <table cellpadding="0" cellspacing="0" border="0" class="dTable responsive">
                        <thead>
                            <tr>
                                <th><div>Model Name</div></th>
                                <th><div>Model Price</div></th>
                                <th><div>Options</div></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($models as $model)
                            <tr>
                                <td>{{ $model->name }}</td>
                                <td>{{ $model->base_price }}</td>
                                <td>
                                    <a href= "{{ url() }}/admin/products/{{ $product->id }}/models/{{ $model->id }}" class="btn btn-sm btn-default"><i class="icon-file"></i> View</a>
                                    <a href= "{{ url() }}/admin/products/{{ $product->id }}/models/{{ $model->id }}/edit" class="btn btn-sm btn-default"><i class="icon-edit"></i> Edit</a>
                                    {{ Form::open(array('url' => '/admin/products/' . $product->id . '/models/' . $model->id, 'method' => 'delete', 'class' => 'table-form')) }}
                                        {{ Form::button('<i class="icon-trash"></i> Delete', array('type' => 'submit', 'class' => 'btn btn-sm btn-red form-confirm', 'data-confirm' => 'Are you sure you want to delete this model and all properties permanently?')) }}
                                    {{ Form::close(); }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop