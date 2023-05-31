@extends('layouts.app')

@section('content')
    <div id="app">
        <div class="col-md-12">
            <a href="{{ route('app.new') }}">Новые заявки</a>
            <a href="{{ route('app.wait') }}">Заявки назначенные</a>
            <a href="{{ route('app.inprogress') }}">Заявки в работе</a>
            <a href="{{ route('app.done') }}">Заявки выполненные</a>
        </div>
        <applications-component :applications="{{ json_encode($applications) }}"></applications-component>
    </div>
@endsection