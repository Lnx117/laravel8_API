@extends('layouts.app')

@section('content')
    <div id="app">
        @include('ApplicationsPages/appNavPanel')
        <applications-in-progress-component :data="{{ json_encode($data) }}"></applications-in-progress-component>
    </div>
    <?php 
        //var_dump($data);
    ?>
@endsection