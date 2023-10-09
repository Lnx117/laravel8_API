<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Config;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\UsersServiceInterface;

class UsersService implements UsersServiceInterface
{
    protected $userRepository;
    private $apiStatuses;
    private $masterStatuses;
    private $roles;

    //Dependency injection
    //UsersService получает на вход реализацию интерфейса UserRepositoryInterface
    //Реализация прописана в провайдере который создает объект
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->apiStatuses = config('ApiStatus');
        $this->masterStatuses = config('MasterStatuses');
        $this->roles = config('Roles');
    }

    protected $response = [
        'status' => '',
        'message' => '',
        'data' => '',
    ];

    public function getUsersList()
    {
        //Получаем список рользователей
        $this->response['data'] = $this->userRepository->getAllUsers();
        $this->response['message'] = 'All users list';
        $this->response['status'] = $this->apiStatuses['ok'];

        return $this->response;
    }

    public function updateUserByIdOrEmail($request, $userIdOrEmail)
    {
        // проверяем, является ли параметр идентификатором пользователя
        if (is_numeric($userIdOrEmail)) {
            $user = $this->userRepository->getById($userIdOrEmail);
        } else {
            // в противном случае ищем пользователя по email
            $user = $this->userRepository->getByEmail($userIdOrEmail);
        }

        if (!$user) {
            $this->response['message'] = 'User not found';
            $this->response['status'] = $this->apiStatuses['warning'];
    
            return $this->response;
        }
        // заполняем модель только теми полями, которые пришли в запросе
        $user = $this->userRepository->fill($user, $request->only([
            'name',
            'email',
            'user_status',
            'user_role',
            'user_firstname',
            'user_lastname',
            'user_patronymic',
            'app_ids',
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
        $this->response['status'] = $this->apiStatuses['ok'];

        return $this->response;
    }

    public function getUserByIdOrEmail($userIdOrEmail)
    {
        // проверяем, является ли параметр идентификатором пользователя
        if (is_numeric($userIdOrEmail)) {
            $user = $this->userRepository->getById($userIdOrEmail);
        } else {
            // в противном случае ищем пользователя по email
            $user = $this->userRepository->getByEmail($userIdOrEmail);
        }

        if (!$user) {
            $this->response['message'] = 'User not found';
            $this->response['status'] = $this->apiStatuses['warning'];
    
            return $this->response;
        }

        $this->response['data'] = $user;
        $this->response['message'] = 'User founded successfully';
        $this->response['status'] = $this->apiStatuses['ok'];

        return $this->response;
    }

    public function deleteUserByIdOrEmail($userIdOrEmail)
    {
        // проверяем, является ли параметр идентификатором пользователя
        if (is_numeric($userIdOrEmail)) {
            $user = $this->userRepository->getById($userIdOrEmail);
        } else {
            // в противном случае ищем пользователя по email
            $user = $this->userRepository->getByEmail($userIdOrEmail);
        }

        if (!$user) {
            $this->response['message'] = 'User not found';
            $this->response['status'] = $this->apiStatuses['warning'];
    
            return $this->response;
        }

        $user = $this->userRepository->delete($user);

        if ($user != true) {
            $this->response['message'] = 'User not deleted';
            $this->response['status'] = $this->apiStatuses['warning'];
    
            return $this->response;
        }

        $this->response['data'] = $user;
        $this->response['message'] = 'User deleted successfully';
        $this->response['status'] = $this->apiStatuses['ok'];

        return $this->response;
    }

    public function getUsersByField($request)
    {
        if(is_array($request)) {
            $data = $request;
        } else {
            $data = $request->json()->all();
        }

        // проверяем, является ли параметр идентификатором пользователя
        $app = $this->userRepository->getUsersByField($data);

        if (empty($app)) {
            $this->response['message'] = 'Users not found';
            $this->response['status'] = $this->apiStatuses['warning'];
    
            return $this->response;
        }

        $this->response['data'] = $app;
        $this->response['message'] = 'Users founded successfully';
        $this->response['status'] = $this->apiStatuses['ok'];

        return $this->response;
    }
}