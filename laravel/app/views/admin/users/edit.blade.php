@extends('layouts.admin.admin')

@section('breadcrumbs')
    <?php $breadcrumbs = array(
        ['icon' => 'group', 'label' => 'Users', 'url' => 'users'],
        ['icon' => 'group', 'label' => "{$user->first_name} {$user->last_name}", 'url' => "users/{$user->id}"],
        ['icon' => 'edit', 'label' => "Edit", 'url' => "users/{$user->id}/edit"],
    ); ?>
    @include('admin._bits.breadcrumb', $breadcrumbs)
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <span class="title">Edit {{ $user->first_name }} {{ $user->last_name }}</span>
            </div>
            <div class="box-content">
                {{ Form::model($user, array('url' => 'admin/users/' . $user->id, 'method' => 'put', 'class' => 'form-horizontal fill-up', 'files' => true)) }}
                    <div class="row">
                        <div class="col-lg-6">
                            <ul class="padded separate-sections">
                                
                                @if($errors->count() > 0)
                                <div class="alert alert-danger form-notice">
                                    @foreach($errors->all() as $message)
                                    {{$message}}
                                    @endforeach
                                </div>
                                @endif
                                
                                <div class="form-group">
                                    <label class="control-label col-lg-2">Email</label>
                                    <div class="col-lg-10">
                                        {{ Form::text('email') }}
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-lg-2">First Name</label>
                                    <div class="col-lg-10">
                                        {{ Form::text('first_name') }}
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-lg-2">Last Name</label>
                                    <div class="col-lg-10">
                                        {{ Form::text('last_name') }}
                                    </div>
                                </div>
                            
                                <div class="form-group">
                                    <label class="control-label col-lg-2">Avatar</label>
                                    <div class="col-lg-10">
                                        {{ Form::file('avatar') }}
                                        <span class="help-block">Optional, jpg or jpeg</span>
                                    </div>
                                </div>
                                
                                <div class="form-actions">
                                    {{ Form::button('Update User', array('type' => 'submit', 'class' => 'btn btn-blue')) }}
                                </div>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop