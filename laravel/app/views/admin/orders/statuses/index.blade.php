@extends('layouts.admin.admin')

@section('breadcrumbs')
    <?php $breadcrumbs = array(
        ['icon' => 'truck', 'label' => 'Orders', 'url' => 'orders'],
        ['icon' => 'lemon', 'label' => 'Statuses', 'url' => 'orders/statuses'], 
    ); ?>
    @include('admin._bits.breadcrumb', $breadcrumbs)
@stop

@section('content')
<div class="action-nav-normal action-nav-line">
    <div class="row action-nav-row">
        <div class="col-sm-2 action-nav-button">
            <a href= "{{ url() }}/admin/orders/statuses/create" title="New Status">
                <i class="icon-lemon"></i>
                <span>New Status</span>
            </a>
            <span class="triangle-button green"><i class="icon-plus"></i></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header"><span class="title">Statuses</span></div>
            <div class="box-content">
                <div id="dataTables" class="dTable-no-header">
                    <table cellpadding="0" cellspacing="0" border="0" class="dTable responsive">
                        <thead>
                            <tr>
                                <th><div>Label</div></th>
                                <th><div>Class</div></th>
                                <th><div>Options</div></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($statuses as $status)
                            <tr>
                                <td><span class="btn btn-sm btn-{{ $status->class}}">{{ $status->name }}</span></td>
                                <td>{{ $status->class }}</td>
                                <td>
                                    <a href= "{{ url() }}/admin/orders/statuses/{{ $status->id }}/edit" class="btn btn-sm btn-default"><i class="icon-edit"></i> Edit</a>
                                    {{ Form::open(array('url' => '/admin/orders/statuses/' . $status->id, 'method' => 'delete', 'class' => 'table-form')) }}
                                        {{ Form::button('<i class="icon-trash"></i> Delete', array('type' => 'submit', 'class' => 'btn btn-sm btn-red form-confirm', 'data-confirm' => 'Are you sure you want to delete this status permanently?')) }}
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