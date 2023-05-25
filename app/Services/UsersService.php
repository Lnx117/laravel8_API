<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Config;

class UsersService
{
    protected $response = [
        'status' => '',
        'message' => '',
        'data' => '',
    ];

    public function getUsersList()
    {
        //Получаем статусы ответа
        $statuses = config('ApiStatus');

        //Получаем список рользователей
        $this->response['data'] = User::all();
        $this->response['message'] = 'All users list';
        $this->response['status'] = $statuses['ok'];

        return $this->response;
    }

    public function updateUserByIdOrEmail($request, $user)
    {
        //Получаем статусы ответа
        $statuses = config('ApiStatus');

        // проверяем, является ли параметр идентификатором пользователя
        if (is_numeric($user)) {
            $user = User::find($user);
        } else {
            // в противном случае ищем пользователя по email
            $user = User::where('email', $user)->firstOrFail();
        }

        if (!$user) {
            $this->response['message'] = 'User not found';
            $this->response['status'] = $statuses['warning'];
    
            return $this->response;
        }
        // заполняем модель только теми полями, которые пришли в запросе
        // пока обновляем либо имя, либо пароль
        $user->fill($request->only([
            'name',
            'email',
        ]));

        // сохраняем изменения в базу данных
        $user->save();

        $user = User::find($user);
        $this->response['data'] = $user;
        $this->response['message'] = 'User updated successfully';
        $this->response['status'] = $statuses['ok'];

        return $this->response;
    }

    public function getUserByIdOrEmail($idOrEmail)
    {

        //Получаем статусы ответа
        $statuses = config('ApiStatus');

        // проверяем, является ли параметр идентификатором пользователя
        if (is_numeric($idOrEmail)) {
            $user = User::find($idOrEmail);
        } else {
            // в противном случае ищем пользователя по email
            $user = User::where('email', $idOrEmail)->firstOrFail();
        }

        if (!$user) {
            $this->response['message'] = 'User not found';
            $this->response['status'] = $statuses['warning'];
    
            return $this->response;
        }

        $this->response['data'] = $user;
        $this->response['message'] = 'User founded successfully';
        $this->response['status'] = $statuses['ok'];

        return $this->response;
    }

    public function deleteUserByIdOrEmail($idOrEmail)
    {
        //Получаем статусы ответа
        $statuses = config('ApiStatus');

        // проверяем, является ли параметр идентификатором пользователя
        if (is_numeric($idOrEmail)) {
            $user = User::find($idOrEmail);
        } else {
            // в противном случае ищем пользователя по email
            $user = User::where('email', $idOrEmail)->firstOrFail();
        }

        if (!$user) {
            $this->response['message'] = 'User not found';
            $this->response['status'] = $statuses['warning'];
    
            return $this->response;
        }

        $user = $user->delete();

        if ($user != true) {
            $this->response['message'] = 'User not deleted';
            $this->response['status'] = $statuses['warning'];
    
            return $this->response;
        }

        $this->response['data'] = $user;
        $this->response['message'] = 'User deleted successfully';
        $this->response['status'] = $statuses['ok'];

        return $this->response;
    }
}