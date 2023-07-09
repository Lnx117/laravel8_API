@extends('layouts.app')

@section('content')
    <div id="app">
        @include('ApplicationsPages/appNavPanel')
        <applications-done-component :data="{{ json_encode($data) }}"></applications-done-component>
    </div>
    <?php 
    ?>
@endsection