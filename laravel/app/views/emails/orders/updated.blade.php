@extends('layouts.email.email')

@section('content')
{{ nl2br($body) }}
@stop