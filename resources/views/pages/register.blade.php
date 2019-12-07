@extends('layouts.app')

@section('body')
    <div id="register" class="box" data-login-route="{{ json_encode(route('login.index')) }}"></div>
@endsection
