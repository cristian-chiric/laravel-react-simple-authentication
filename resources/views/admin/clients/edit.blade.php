@extends('layouts.app')

@section('body')
    <div id="client" class="box" data-action='"edit"' data-client="{{ json_encode($client) }}"></div>
@endsection
