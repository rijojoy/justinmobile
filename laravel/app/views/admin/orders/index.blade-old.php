@extends('layouts.admin.admin')

@section('breadcrumbs')
    <?php $breadcrumbs = array(
        ['icon' => 'truck', 'label' => 'Orders', 'url' => 'orders'], 
    ); ?>
    @include('admin._bits.breadcrumb', $breadcrumbs)
@stop

@section('content')
<div class="action-nav-normal action-nav-line">
    <div class="row action-nav-row">
        <div class="col-sm-2 action-nav-button">
            <a href= "{{ url() }}/admin/orders/statuses" title="Statuses">
                <i class="icon-lemon"></i>
                <span>Statuses</span>
            </a>
            <span class="triangle-button green"><i class="icon-wrench"></i></span>
        </div>
        <div class="col-sm-2 action-nav-button">
            <a href= "{{ url() }}/admin/orders/templates" title="Statuses">
                <i class="icon-envelope"></i>
                <span>Note Templates</span>
            </a>
            <span class="triangle-button green"><i class="icon-wrench"></i></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <ul class="nav nav-tabs nav-tabs-left">
                    <li<?php if($filter == 'status' || $filter == false) { ?> class="active"<?php } ?>><a href="#statuses" data-toggle="tab"><i class="icon-lemon"></i> <span>Filter By Status</span></a></li>
                    <li<?php if($filter == 'product') { ?> class="active"<?php } ?>><a href="#products" data-toggle="tab"><i class="icon-mobile-phone"></i> <span>Filter By Product</span></a></li>
                </ul>
            </div>
            <div class="box-content padded">
                <div class="tab-content">
                    <div class="tab-pane<?php if($filter == 'status' || $filter == false) { ?> active<?php } ?>" id="statuses">
                        @foreach ($statuses as $status)
                        <a class="btn btn-sm btn-{{ $status->class }}" href="?status={{ $status->id }}">{{ $status->name }}</a>
                        @endforeach
                    </div>
                    <div class="tab-pane<?php if($filter == 'product') { ?> active<?php } ?>" id="products">
                        @foreach ($products as $product)
                        <a class="btn btn-sm btn-default" href="?product={{ $product->id }}">{{ $product->name }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <span class="title">
                    Orders
                </span>
                <ul class="box-toolbar">
                    @if ($filter == 'status')
                    <li><span class="btn btn-xs btn-{{ $filter_val->class }}">{{ $filter_val->name }}</span></li>
                    @elseif ($filter == 'product')
                    <li><span class="btn btn-xs btn-default">{{ $filter_val->name }}</span></li>
                    @endif
                </ul>
            </div>
            <script type="text/javascript">
                $(document).ready(function() {
                    $("#order-list").dataTable({
                        aaSorting: [[ 5, "desc" ]],
                        aoColumns : [null, null, null, null, null, { "bSearchable": true, "bVisible": false }, null, null],
                        bJQueryUI: false,
                        bAutoWidth: false,
                        sPaginationType: "full_numbers",
                        sDom: "<\"table-header\"fl>t<\"table-footer\"ip>"
                    });
                });
            </script>
            <div class="box-content">
                <div class="dTable-no-header">
                    <table id="order-list" cellpadding="0" cellspacing="0" border="0" class="responsive">
                        <thead>
                            <tr>
                                <th><div>Status</div></th>
                                <th><div>Product</div></th>
                                <th><div>Model</div></th>
                                <th><div>Name</div></th>
                                <th><div>Last Updated</div></th>
                                <th stlye="display: none;"><div>Last Updated raw</div></th>
                                <th><div>Order Placed</div></th>
                                <th><div>Options</div></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order) 
                            <tr>
                                <?php $person = json_decode($order->personal_info); ?>
                                <td><span class="btn btn-sm btn-{{ $order->status->class}}">
                                        @if($order->status && $order->status->name)
                                            {{ $order->status->name }}
                                        @endif
                                    </span></td>
                                <td>
                                    @if($order->product && $order->product->name)
                                        {{ $order->product->name }}
                                    @endif
                                </td>
                                <td>
                                    @if($order->model && $order->model->name)
                                        {{ $order->model->name }}
                                    @endif
                                </td>
                                <td>
                                    @if($person->name)
                                        {{ $person->name }}
                                    @endif
                                </td>
                                <td title="{{ $order->updated_at }}">
                                    @if($order->updated_at)
                                        {{ $order->updated_at->diffForHumans() }}
                                    @endif
                                </td>
                                <td stlye="display: none;">
                                    @if($order->updated_at)
                                        {{ strtotime($order->updated_at) }}
                                    @endif
                                </td>
                                <td title="{{ $order->created_at }}">
                                    @if($order->created_at)
                                        {{ $order->created_at->diffForHumans() }}
                                    @endif
                                </td>
                                <td>
                                    <a href= "{{ url() }}/admin/orders/{{ $order->id }}" class="btn btn-sm btn-default"><i class="icon-truck"></i> View</a>
                                    <a href= "{{ url() }}/admin/orders/{{ $order->id }}/notes/create" class="btn btn-sm btn-default"><i class="icon-pencil"></i> Update</a>
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