@extends('layouts.admin.admin')

@section('breadcrumbs')
    <?php $breadcrumbs = array(
        ['icon' => 'mobile-phone', 'label' => 'Products', 'url' => 'products'],
        ['icon' => 'mobile-phone', 'label' => $product->name, 'url' => 'products/' . $product->id],
        ['icon' => 'mobile-phone', 'label' => $model->name, 'url' => 'products/' . $product->id . '/models/' . $model->id]
    ); ?>
    @include('admin._bits.breadcrumb', $breadcrumbs)
@stop

@section('content')
<div class="action-nav-normal action-nav-line">
    <div class="row action-nav-row">
        <div class="col-sm-2 action-nav-button">
            <a href= "{{ url() }}/admin/products/{{ $product->id }}/models/{{ $model->id }}/edit" title="Edit Model">
                <i class="icon-mobile-phone"></i>
                <span>Edit Model</span>
            </a>
            <span class="triangle-button green"><i class="icon-edit"></i></span>
        </div>
        <div class="col-sm-2 action-nav-button">
            <a href= "{{ url() }}/admin/products/{{ $product->id }}/models/{{ $model->id }}/properties/create" title="New Property">
                <i class="icon-lightbulb"></i>
                <span>New Property</span>
            </a>
            <span class="triangle-button green"><i class="icon-plus"></i></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header"><span class="title">Properties</span></div>
            <div class="box-content">
                <div id="dataTables" class="dTable-no-header">
                    <table cellpadding="0" cellspacing="0" border="0" class="dTable responsive">
                        <thead>
                            <tr>
                                <th><div>Order</div></th>
                                <th><div>Name</div></th>
                                <th><div>Options</div></th>
                            </tr>
                        </thead>
                            @foreach ($properties as $property)
                            <tr>
                                <td>{{ $property->order }}</td>
                                <td>{{ $property->name }}</td>
                                <td>
                                    <a href= "{{ url() }}/admin/products/{{ $product->id }}/models/{{ $model->id }}/properties/{{ $property->id }}" class="btn btn-sm btn-default"><i class="icon-file"></i> View</a>
                                    <a href= "{{ url() }}/admin/products/{{ $product->id }}/models/{{ $model->id }}/properties/{{ $property->id }}/edit" class="btn btn-sm btn-default"><i class="icon-edit"></i> Edit</a>
                                    {{ Form::open(array('url' => '/admin/products/' . $product->id . '/models/' . $model->id . '/properties/' . $property->id, 'method' => 'delete', 'class' => 'table-form')) }}
                                        {{ Form::button('<i class="icon-trash"></i> Delete', array('type' => 'submit', 'class' => 'btn btn-sm btn-red form-confirm', 'data-confirm' => 'Are you sure you want to delete this property and all options permanently?')) }}
                                    {{ Form::close() }}
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