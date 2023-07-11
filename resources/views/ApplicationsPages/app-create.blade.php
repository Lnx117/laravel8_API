@extends('layouts.app')

@section('content')
    <div id="app">
        <applications-create-component :data="{{ json_encode($data) }}"></applications-create-component>
    </div>
@endsection