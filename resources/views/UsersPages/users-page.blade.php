@extends('layouts.app')

@section('content')
    <div id="app">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <a href="{{ route('users.free') }}" class="{{ request()->is('users/free') ? 'appActiveLink' : '' }} appPagesLink">Свободные мастера</a>
                    <a href="{{ route('users.working') }}" class="{{ request()->is('users/working') ? 'appActiveLink' : '' }} appPagesLink">Мастера за работой</a>
                    <a href="{{ route('users.vacatioin') }}" class="{{ request()->is('users/vacatioin') ? 'appActiveLink' : '' }} appPagesLink">Мастера в отпуске/выходной</a>
                    
                </div>
            </div>
        </div>
        <users-component :users="{{ json_encode($users) }}"></users-component>
    </div>
@endsection