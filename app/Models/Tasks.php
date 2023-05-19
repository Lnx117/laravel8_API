<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    //Позволяет создавать фейковых пользователей. Полезно для тестирования. Можно посмотреть в D:\OpenServer\OpenServer\domains\laravelApi\tests\Feature\Test.php
    use HasFactory;

    //Привязывает к таблице в бд. Выдает соответствующие поля
    protected $table = 'tasks_table';

    //Делает поля изменяемыми для методов. Чтобы поменять значение и сохранить в бд нужно делать так
    protected $fillable = [
        'application_id', 'master_id', 'status',
    ];
}
