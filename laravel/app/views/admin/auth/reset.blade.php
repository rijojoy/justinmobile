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
                <span class="title">Reset</span>
            </div>
            
            <div class="box-content padded">
                {{ Form::open(array('url' => 'admin/auth/reset', 'method' => 'post', 'class' => 'separate-sections', 'autocomplete' => 'off')) }}
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
                
                    <div class="input-group addon-left">
                        <span class="input-group-addon" href="#">
                            <i class="icon-key"></i>
                        </span>
                        {{ Form::password('password_confirm', array('placeholder' => 'Confirm Password')) }}
                    </div>
                
                    {{ Form::hidden('code', $code) }}

                    <div>
                        {{ Form::submit('Reset Password', array('class' => 'btn btn-blue btn-block')) }}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@stop