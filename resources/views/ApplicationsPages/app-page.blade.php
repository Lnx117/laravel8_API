@extends('layouts.app')

@section('content')
    <div id="app">
        @include('ApplicationsPages/appNavPanel')
        <applications-component :data="{{ json_encode($data) }}"></applications-component>
    </div>
    <?php 
        //var_dump($data);
    ?>
@endsection