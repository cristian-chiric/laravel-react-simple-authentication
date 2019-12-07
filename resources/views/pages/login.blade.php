@extends('layouts.app')

@section('body')
    <div id="login" class="box"
         data-register-route="{{ json_encode(route('register.index')) }}"
         @error('message')
            data-error="{{ json_encode($message) }}"
        @enderror></div>
@endsection
