@extends('layouts.app')

@section('content')
    <div id="app">
        <applications-component :applications="{{ json_encode($applications) }}"></applications-component>
    </div>
@endsection