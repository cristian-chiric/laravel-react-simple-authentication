@extends('layouts.app')

@section('body')
    <div id="dashboard" class="box" data-name="{{ json_encode(auth()->user()->name) }}" data-total-clients={{ $totalClients }}></div>
@endsection
