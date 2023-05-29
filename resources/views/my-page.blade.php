@extends('layouts.app')

@section('content')
    <div id="app">
        <example-component :applications="{{ json_encode($applications) }}"></example-component>
    </div>
@endsection