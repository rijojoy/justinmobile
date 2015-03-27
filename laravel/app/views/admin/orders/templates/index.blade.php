@extends('layouts.admin.admin')

@section('breadcrumbs')
    <?php $breadcrumbs = array(
        ['icon' => 'truck', 'label' => 'Orders', 'url' => 'orders'],
        ['icon' => 'envelope', 'label' => 'Templates', 'url' => 'orders/templates'], 
    ); ?>
    @include('admin._bits.breadcrumb', $breadcrumbs)
@stop

@section('content')
<div class="action-nav-normal action-nav-line">
    <div class="row action-nav-row">
        <div class="col-sm-2 action-nav-button">
            <a href= "{{ url() }}/admin/orders/templates/create" title="New Template">
                <i class="icon-envelope"></i>
                <span>New Template</span>
            </a>
            <span class="triangle-button green"><i class="icon-plus"></i></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header"><span class="title">Templates</span></div>
            <div class="box-content">
                <div id="dataTables" class="dTable-no-header">
                    <table cellpadding="0" cellspacing="0" border="0" class="dTable responsive">
                        <thead>
                            <tr>
                                <th><div>Name</div></th>
                                <th><div>Status</div></th>
                                <th><div>Options</div></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($templates as $template)
                            <tr>
                                <td>{{ $template->name }}</td>
                                <td><span class="btn btn-sm btn-{{ $template->status->class }}">{{ $template->status->name }}</span></td>
                                <td>
                                    <a href= "{{ url() }}/admin/orders/templates/{{ $template->id }}/edit" class="btn btn-sm btn-default"><i class="icon-edit"></i> Edit</a>
                                    {{ Form::open(array('url' => '/admin/orders/templates/' . $template->id, 'method' => 'delete', 'class' => 'table-form')) }}
                                        {{ Form::button('<i class="icon-trash"></i> Delete', array('type' => 'submit', 'class' => 'btn btn-sm btn-red form-confirm', 'data-confirm' => 'Are you sure you want to delete this template permanently?')) }}
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