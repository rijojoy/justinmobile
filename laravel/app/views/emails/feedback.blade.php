@extends('layouts.email.email')

@section('content')
Feedback has been given by ORDER ID {{ $order->id }}<br/>
Their message is as follows: <br/><br/>
{{ $input['message'] }} 
<br/><br/>
Their order can be found here: {{ link_to('admin/orders/' . $order->id) }}
@stop