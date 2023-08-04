@extends('layouts.app')

@section('content')
    <div id="app">
        <managers-create-component :data="{{ json_encode($data) }}"></managers-create-component>
    </div>
@endsection