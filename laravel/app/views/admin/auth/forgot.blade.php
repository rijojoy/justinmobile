@extends('layouts.admin.auth')

@section('content')
<div class="col-md-4 col-md-offset-4">
    <div class="padded">
        
        @if($errors->count() > 0)
        <div class="alert alert-danger form-notice">
            @foreach($errors->all() as $message)
            {{$message}}
            @endforeach
        </div>
        @endif
        
        <div class="login box">
            <div class="box-header">
                <span class="title">Password Reset</span>
            </div>
            
            <div class="box-content padded">
                @if(Session::has('message'))
                    <div class="alert alert-global alert-success">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        {{ Session::get('message') }}
                    </div>
                @endif
                
                {{ Form::open(array('url' => 'admin/auth/forgot', 'method' => 'post', 'class' => 'separate-sections')) }}
                    <div class="input-group addon-left">
                        <span class="input-group-addon" href="#">
                            <i class="icon-user"></i>
                        </span>
                        {{ Form::text('email', null, array('autofocus', 'placeholder' => 'Email')) }}
                    </div>

                    <div>
                        {{ Form::submit('Reset Password', array('class' => 'btn btn-blue btn-block')) }}
                    </div>
                {{ Form::close() }}
                <div>
                    <a href= "{{ url() }}/admin/auth/login">
                        Go back to login?
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@stop