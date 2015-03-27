@extends('layouts.admin.admin')

@section('breadcrumbs')
    <?php $breadcrumbs = array(
        ['icon' => 'home', 'label' => 'Dashboard', 'url' => 'dashboard'], 
    ); ?>
    @include('admin._bits.breadcrumb', $breadcrumbs)
@stop

@section('content')
<?php 
$monday = strtotime('last monday', strtotime('tomorrow'));
$days_ts = range($monday, ($monday + (86400 * 7)), 86400);

foreach ($days_ts as $day) {
    $days[date('Y-m-d', $day) . ' 00:00:00'] = '0';
}

foreach ($orders_week as $order) { 
    $time = strtotime($order->created_at);
    $days[date('Y-m-d', $time) . ' 00:00:00'] += 1;
} ?>
<script type="text/javascript">
    $(function () {
    var data = [
        {
            "xScale":"ordinal",
            "comp":[],
            "main":[
                {
                    "className":".main.l1",
                    "data":[
                        <?php $data = ''; foreach ($days as $day => $amt) {
                            $data .= '{"y":'.$amt.',"x":"'.$day.'"},'."\n";
                        } $data = substr($data, 0, -2); echo $data; ?>
                    ]
                }
            ],
            "type":"bar",
            "yScale":"linear"
        }
    ];

    var order = [0, 1, 0, 2],
        i = 0,
        xFormat = d3.time.format('%A'),
        chart;

    if ($("#xchart-sales").length > 0) {
        chart = new xChart('bar', data[order[i]], '#xchart-sales', {
            axisPaddingTop: 5,
            paddingLeft: 30,
            dataFormatX: function (x) { return new Date(x); },
            tickFormatX: function (x) { return d3.time.format('%a')(x); }
        });
    }
});
</script>
<div class="row">
    <div class="col-md-6">
        <div class="box">
            <div class="box-header"><span class="title">Weekly Orders</span></div>
            <div class="box-content padded">
                <div class="sine-chart" style="height: 300px" id="xchart-sales"></div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box">
            <div class="box-header"><span class="title">Latest 10 Orders</span></div>
            <div class="box-content padded">
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
                <div  class="dTable-no-header">
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
                            @foreach ($orders_new as $order) 
                            <tr>
                                <?php $person = json_decode($order->personal_info); ?>
                                <td><span class="btn btn-sm btn-{{ $order->status->class}}">{{ $order->status->name }}</span></td>
                                <td>{{ $order->product->name }}</td>
                                <td>{{ $order->model->name }}</td>
                                <td>{{ $person->name }}</td>
                                <td title="{{ $order->updated_at }}">{{ $order->updated_at->diffForHumans() }}</td>
                                <td stlye="display: none;">{{ strtotime($order->updated_at) }}</td>
                                <td title="{{ $order->created_at }}">{{ $order->created_at->diffForHumans() }}</td>
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