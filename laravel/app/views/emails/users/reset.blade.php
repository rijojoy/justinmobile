@extends('layouts.email.email')

@section('content')
{{ $user->first_name }},<br/>
A password reset has been requested for your account on {{ Config::get('recycle.name') }}.<br/><br/>
To reset your password visit: {{ link_to('admin/auth/reset/' . $reset_code) }}
@stop