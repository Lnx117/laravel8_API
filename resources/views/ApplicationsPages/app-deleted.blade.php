@extends('layouts.app')

@section('content')
    <div id="app">
        @include('ApplicationsPages/appNavPanel')
        <applications-deleted-component :data="{{ json_encode($data) }}"></applications-deleted-component>
    </div>
    <?php 
    ?>
@endsection