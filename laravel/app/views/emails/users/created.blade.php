@extends('layouts.email.email')

@section('content')
{{ $user->first_name }},<br/>
An account has been created for you on Recycle, your account details are as follows:<br/>
<strong>Name:</strong> {{ $user->first_name }} {{ $user->last_name }}<br/>
<strong>Email:</strong> {{ $user->email }}<br/>
<strong>Password:</strong> {{ $password }}<br/>
To login visit: {{ link_to('admin/auth/login') }}
@stop