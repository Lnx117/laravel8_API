<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Config;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\UsersServiceInterface;

class UsersService implements UsersServiceInterface
{
    protected $userRepository;

    //Dependency injection
    //UsersService получает на вход реализацию интерфейса UserRepositoryInterface
    //Реализация прописана в провайдере который создает объект
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

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
        $this->response['data'] = $this->userRepository->getAllUsers();
        $this->response['message'] = 'All users list';
        $this->response['status'] = $statuses['ok'];

        return $this->response;
    }

    public function updateUserByIdOrEmail($request, $userIdOrEmail)
    {
        //Получаем статусы ответа
        $statuses = config('ApiStatus');

        // проверяем, является ли параметр идентификатором пользователя
        if (is_numeric($userIdOrEmail)) {
            $user = $this->userRepository->getById($userIdOrEmail);
        } else {
            // в противном случае ищем пользователя по email
            $user = $this->userRepository->getByEmail($userIdOrEmail);
        }

        if (!$user) {
            $this->response['message'] = 'User not found';
            $this->response['status'] = $statuses['warning'];
    
            return $this->response;
        }
        // заполняем модель только теми полями, которые пришли в запросе
        // пока обновляем либо имя, либо пароль
        $user = $this->userRepository->fill($user, $request->only([
            'name',
            'email',
            'user_status',
            'user_role',
            'user_firstname',
            'user_lastname',
            'user_patronymic',
        ]));

        // сохраняем изменения в базу данных
        $this->userRepository->save($user);

        if (is_numeric($userIdOrEmail)) {
            $user = $this->userRepository->getById($userIdOrEmail);
        } else {
            // в противном случае ищем пользователя по email
            $user = $this->userRepository->getByEmail($userIdOrEmail);
        }

        $this->response['data'] = $user;
        $this->response['message'] = 'User updated successfully';
        $this->response['status'] = $statuses['ok'];

        return $this->response;
    }

    public function getUserByIdOrEmail($userIdOrEmail)
    {

        //Получаем статусы ответа
        $statuses = config('ApiStatus');

        // проверяем, является ли параметр идентификатором пользователя
        if (is_numeric($userIdOrEmail)) {
            $user = $this->userRepository->getById($userIdOrEmail);
        } else {
            // в противном случае ищем пользователя по email
            $user = $this->userRepository->getByEmail($userIdOrEmail);
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

    public function deleteUserByIdOrEmail($userIdOrEmail)
    {
        //Получаем статусы ответа
        $statuses = config('ApiStatus');

        // проверяем, является ли параметр идентификатором пользователя
        if (is_numeric($userIdOrEmail)) {
            $user = $this->userRepository->getById($userIdOrEmail);
        } else {
            // в противном случае ищем пользователя по email
            $user = $this->userRepository->getByEmail($userIdOrEmail);
        }

        if (!$user) {
            $this->response['message'] = 'User not found';
            $this->response['status'] = $statuses['warning'];
    
            return $this->response;
        }

        $user = $this->userRepository->delete($user);

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

    public function getUsersByField($request)
    {
        $statuses = config('ApiStatus');

        if(is_array($request)) {
            $data = $request;
        } else {
            $data = $request->json()->all();
        }

        // проверяем, является ли параметр идентификатором пользователя
        $app = $this->userRepository->getUsersByField($data);

        if (empty($app)) {
            $this->response['message'] = 'Users not found';
            $this->response['status'] = $statuses['warning'];
    
            return $this->response;
        }

        $this->response['data'] = $app;
        $this->response['message'] = 'Users founded successfully';
        $this->response['status'] = $statuses['ok'];

        return $this->response;
    }
}