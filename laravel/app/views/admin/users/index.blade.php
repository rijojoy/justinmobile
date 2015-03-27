@extends('layouts.admin.admin')

@section('breadcrumbs')
    <?php $breadcrumbs = array(
        ['icon' => 'group', 'label' => 'Users', 'url' => 'users']
    ); ?>
    @include('admin._bits.breadcrumb', $breadcrumbs)
@stop

@section('content')
<div class="action-nav-normal action-nav-line">
    <div class="row action-nav-row">
        <div class="col-sm-2 action-nav-button">
            <a href= "{{ url() }}/admin/users/create" title="New User">
                <i class="icon-user"></i>
                <span>New User</span>
            </a>
            <span class="triangle-button green"><i class="icon-plus"></i></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header"><span class="title">Administrators</span></div>
            <div class="box-content">
                <div id="dataTables" class="dTable-no-header">
                    <table cellpadding="0" cellspacing="0" border="0" class="dTable responsive">
                        <thead>
                            <tr>
                                <th><div>Email</div></th>
                                <th><div>Name</div></th>
                                <th><div>Last Login</div></th>
                                <th><div>Options</div></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                <td>{{ $user->last_login }}</td>
                                <td>
                                    <a href= "{{ url() }}/admin/users/{{ $user->id }}/edit" class="btn btn-sm btn-default"><i class="icon-edit"></i> Edit</a>
                                    {{ Form::open(array('url' => '/admin/users/' . $user->id, 'method' => 'delete', 'class' => 'table-form')) }}
                                        {{ Form::button('<i class="icon-trash"></i> Delete', array('type' => 'submit', 'class' => 'btn btn-sm btn-red form-confirm', 'data-confirm' => 'Are you sure you want to delete this user permanently?')) }}
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