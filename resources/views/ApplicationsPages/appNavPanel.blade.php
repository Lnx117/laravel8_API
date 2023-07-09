<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <a href="{{ route('app.new') }}" class="{{ request()->is('app/new') ? 'appActiveLink' : '' }} appPagesLink">Новые заявки</a>
            <a href="{{ route('app.wait') }}" class="{{ request()->is('app/wait') ? 'appActiveLink' : '' }} appPagesLink">Заявки назначенные</a>
            <a href="{{ route('app.inProgress') }}" class="{{ request()->is('app/inProgress') ? 'appActiveLink' : '' }} appPagesLink">Заявки в работе</a>
            <a href="{{ route('app.done') }}" class="{{ request()->is('app/done') ? 'appActiveLink' : '' }} appPagesLink">Заявки выполненные</a>
            <a href="{{ route('app.deleted') }}" class="{{ request()->is('app/deleted') ? 'appActiveLink' : '' }} appPagesLink">Удаленные заявки</a>
        </div>
    </div>
</div>