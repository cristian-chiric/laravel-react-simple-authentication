@extends('layouts.app')

@section('body')
    <div id="clients" class="box"
         data-name="{{ json_encode(auth()->user()->name) }}"
         data-clients="{{ json_encode($clients) }}"
         data-total-clients={{ $totalClients }}></div>
@endsection
