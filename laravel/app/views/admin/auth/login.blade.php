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
                <span class="title">Login</span>
            </div>
            
            <div class="box-content padded">
                @if(Session::has('message'))
                    <div class="alert alert-global alert-success">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        {{ Session::get('message') }}
                    </div>
                @endif
                
                {{ Form::open(array('url' => 'admin/auth/login', 'method' => 'post', 'class' => 'separate-sections')) }}
                    <div class="input-group addon-left">
                        <span class="input-group-addon" href="#">
                            <i class="icon-user"></i>
                        </span>
                        {{ Form::text('email', null, array('autofocus', 'placeholder' => 'Email')) }}
                    </div>

                    <div class="input-group addon-left">
                        <span class="input-group-addon" href="#">
                            <i class="icon-key"></i>
                        </span>
                        {{ Form::password('password', array('placeholder' => 'Password')) }}
                    </div>

                    <div>
                        {{ Form::submit('Login', array('class' => 'btn btn-blue btn-block')) }}
                    </div>
                {{ Form::close() }}
                <div>
                    <a href= "{{ url() }}/admin/auth/forgot">
                        Forgotten password? <strong>Reset &rarr;</strong>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@stop