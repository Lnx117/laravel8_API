@extends('layouts.app')

@section('content')
    <div id="app">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <a href="{{ route('users.managers') }}" class="{{ request()->is('users/managers') ? 'appActiveLink' : '' }} appPagesLink">Активные менеджеры</a> 
                    <a href="{{ route('users.managersDeleted') }}" class="{{ request()->is('users/managersDeleted') ? 'appActiveLink' : '' }} appPagesLink">Удаленные менеджеры</a> 
                </div>
            </div>
        </div>
        <managers-component :data="{{ json_encode($data) }}"></managers-component>
    </div>
@endsection