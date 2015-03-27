@extends('layouts.admin.admin')

@section('breadcrumbs')
    <?php $breadcrumbs = array(
        ['icon' => 'mobile-phone', 'label' => 'Products', 'url' => 'products']
    ); ?>
    @include('admin._bits.breadcrumb', $breadcrumbs)
@stop

@section('content')
<div class="action-nav-normal action-nav-line">
    <div class="row action-nav-row">
        <div class="col-sm-2 action-nav-button">
            <a href= "{{ url() }}/admin/products/create" title="New Product">
                <i class="icon-mobile-phone"></i>
                <span>New Product</span>
            </a>
            <span class="triangle-button green"><i class="icon-plus"></i></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header"><span class="title">Products</span></div>
            <div class="box-content">
                <div id="dataTables" class="dTable-no-header">
                    <table cellpadding="0" cellspacing="0" border="0" class="dTable responsive">
                        <thead>
                            <tr>
                                <th><div>Product</div></th>
                                <th><div>Slug</div></th>
                                <th><div>Options</div></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->name }} @if ($product->default == 1) <span class="label label-green">Default</span> @endif</td>
                                <td>{{ $product->slug }}</td>
                                <td>
                                    <a href= "{{ url() }}/admin/products/{{ $product->id }}" class="btn btn-sm btn-default"><i class="icon-file"></i> View</a>
                                    <a href= "{{ url() }}/admin/products/{{ $product->id }}/edit" class="btn btn-sm btn-default"><i class="icon-edit"></i> Edit</a>
                                    {{ Form::open(array('url' => '/admin/products/' . $product->id, 'method' => 'delete', 'class' => 'table-form')) }}
                                        {{ Form::button('<i class="icon-trash"></i> Delete', array('type' => 'submit', 'class' => 'btn btn-sm btn-red form-confirm', 'data-confirm' => 'Are you sure you want to delete this product permanently?')) }}
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