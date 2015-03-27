@extends('layouts.admin.admin')

@section('breadcrumbs')
    <?php $breadcrumbs = array(
        ['icon' => 'group', 'label' => 'Users', 'url' => 'users'],
        ['icon' => 'group', 'label' => "{$user->first_name} {$user->last_name}", 'url' => "users/{$user->id}"],
    ); ?>
    @include('admin._bits.breadcrumb', $breadcrumbs)
@stop

@section('content')
<div class="action-nav-normal action-nav-line">
    <div class="row action-nav-row">
        <div class="col-sm-2 action-nav-button">
            <a href= "{{ url() }}/admin/users/{{ $user->id }}/edit" title="Edit User">
                <i class="icon-user"></i>
                <span>Edit User</span>
            </a>
            <span class="triangle-button green"><i class="icon-edit"></i></span>
        </div>
    </div>
</div>
@stop