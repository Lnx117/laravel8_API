<?php
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiUsersRouteTest extends TestCase
{
    //Использует бд которая в .env описана как DB_TEST_продолжение, а в config/database.php как
    //mysql_testing. Используется по дефолту потому что указана в config/database.php в параметре testing
    //в качестве дефолтной.
    //RefreshDatabase чистит базу
    use RefreshDatabase;

    //Используем для генерации различных полей
    //Например $newName = $this->faker->name;
    use WithFaker;

    //Сюда сохраним юзера с которым будем работать в других методах
    //Это позволит удалить или изменить его
    protected $user;
    
    public function testGetUsersList()
    {
        $apiStatuses = config('ApiStatus');
        $roles = config('Roles');

        //Создает юзера по модели User
        $this->user = User::factory()->create([
            'user_role' => $roles['manager'],
        ]);
        
        //Использует юзера, не использует явную авторизацию с токенами как в реале, а  юзает временные CSRF токены
        $response = $this->actingAs($this->user, 'sanctum')
            ->get('api/sanctum/getUsersList');
        
        //Проверка на статус ответа
        $response->assertStatus(200);
        //Проверка на то ччто ответ в виде json
        $response->assertJson([
            'message' => 'All users list',
            'status' =>  $apiStatuses['ok'],
        ]);
    }

    public function testGetUsersListByMaster()
    {
        $apiStatuses = config('ApiStatus');
        $roles = config('Roles');

        //Создает юзера по модели User
        $this->user = User::factory()->create([
            'user_role' => $roles['master'],
        ]);
        
        //Использует юзера, не использует явную авторизацию с токенами как в реале, а  юзает временные CSRF токены
        $response = $this->actingAs($this->user, 'sanctum')
            ->get('api/sanctum/getUsersList');
        
        //Проверка на статус ответа
        $response->assertStatus(403);
        //Проверка на то что ответ в виде json
        $response->assertSee("You are not admin or manager!!!");
    }

    public function testGetUsersListByAdmin()
    {
        $apiStatuses = config('ApiStatus');
        $roles = config('Roles');

        //Создает юзера по модели User
        $this->user = User::factory()->create([
            'user_role' => $roles['admin'],
        ]);
        
        //Использует юзера, не использует явную авторизацию с токенами как в реале, а  юзает временные CSRF токены
        $response = $this->actingAs($this->user, 'sanctum')
            ->get('api/sanctum/getUsersList');
        
        //Проверка на статус ответа
        $response->assertStatus(200);
        //Проверка на то что ответ в виде json
        $response->assertJson([
            'message' => 'All users list',
            'status' =>  $apiStatuses['ok'],
        ]);
    }

    public function testGetUsersListByNoRole()
    {
        $apiStatuses = config('ApiStatus');
        $roles = config('Roles');

        //Создает юзера по модели User
        $this->user = User::factory()->create([
            'user_role' => '',
        ]);
        
        //Использует юзера, не использует явную авторизацию с токенами как в реале, а  юзает временные CSRF токены
        $response = $this->actingAs($this->user, 'sanctum')
            ->get('api/sanctum/getUsersList');
        
        //Проверка на статус ответа
        $response->assertStatus(403);
        //Проверка на то что ответ в виде json
        $response->assertSee("You are not admin or manager!!!");
    }

    public function testUpdateUserByIdOrEmail()
    {
        $apiStatuses = config('ApiStatus');
        $roles = config('Roles');

        // Используем старого юзера из свойства protected $user;
        $this->user = User::factory()->create([
            'user_role' => $roles['manager'],
        ]);
        // Генерируем новые данные для обновления
        $newName = $this->faker->name;
        $newEmail = $this->faker->unique()->safeEmail;
        // Выполняем запрос на обновление пользователя
        //Важно как мы указываем параметр в строке это ID или Email
        //а пост данные второй переменной
        $response = $this->actingAs($this->user, 'sanctum')
            ->put('api/sanctum/updateUserByIdOrEmail/'.$this->user->id, [
                'name' => $newName,
                'email' => $newEmail,
            ]);

        // Проверяем успешный ответ и наличие сообщения в JSON-ответе
        // assertJson(['message' => 'User updated successfully']); так можно проверять ответы
        $response->assertStatus(200)
            ->assertJson(['message' => 'User updated successfully']);
        // Проверяем, что данные пользователя были обновлены
        // Ищем юзера по старому id !!!!!!!!!!!!!
        $updatedUser = User::find($this->user->id);
        $this->assertEquals($newName, $updatedUser->name);
        $this->assertEquals($newEmail, $updatedUser->email);
    }

    public function testUpdateUserByIdOrEmailWithWrongRole()
    {
        $apiStatuses = config('ApiStatus');
        $roles = config('Roles');

        // Используем старого юзера из свойства protected $user;
        $this->user = User::factory()->create([
            'user_role' => $roles['master'],
        ]);
        // Генерируем новые данные для обновления
        $newName = $this->faker->name;
        $newEmail = $this->faker->unique()->safeEmail;
        // Выполняем запрос на обновление пользователя
        //Важно как мы указываем параметр в строке это ID или Email
        //а пост данные второй переменной
        $response = $this->actingAs($this->user, 'sanctum')
            ->put('api/sanctum/updateUserByIdOrEmail/'.$this->user->id, [
                'name' => $newName,
                'email' => $newEmail,
            ]);

        //Проверка на статус ответа
        $response->assertStatus(403);
        //Проверка на то что ответ в виде json
        $response->assertSee("You are not admin or manager!!!");
    }

    public function testUpdateUserByIdOrEmailWithWrongIdOrEmail()
    {
        $apiStatuses = config('ApiStatus');
        $roles = config('Roles');

        // Используем старого юзера из свойства protected $user;
        $this->user = User::factory()->create([
            'user_role' => $roles['manager'],
        ]);
        // Генерируем новые данные для обновления
        $newName = $this->faker->name;
        $newEmail = $this->faker->unique()->safeEmail;
        // Выполняем запрос на обновление пользователя
        //Важно как мы указываем параметр в строке это ID или Email
        //а пост данные второй переменной
        $response = $this->actingAs($this->user, 'sanctum')
            ->put('api/sanctum/updateUserByIdOrEmail/'.($this->user->id + 4323), [
                'name' => $newName,
                'email' => $newEmail,
            ]);

        //Проверка на статус ответа
        $response->assertStatus(200);
        //Проверка на то ччто ответ в виде json
        $response->assertJson([
            "status" => "Warning",
            "message" => "User not found",
            "data" => ""
        ]);
    }

    public function testUpdateUserByIdOrEmailWithWrongIdOrEmailByAdmin()
    {
        $apiStatuses = config('ApiStatus');
        $roles = config('Roles');

        // Используем старого юзера из свойства protected $user;
        $this->user = User::factory()->create([
            'user_role' => $roles['admin'],
        ]);
        // Генерируем новые данные для обновления
        $newName = $this->faker->name;
        $newEmail = $this->faker->unique()->safeEmail;
        // Выполняем запрос на обновление пользователя
        //Важно как мы указываем параметр в строке это ID или Email
        //а пост данные второй переменной
        $response = $this->actingAs($this->user, 'sanctum')
            ->put('api/sanctum/updateUserByIdOrEmail/'.$this->user->id, [
                'name' => $newName,
                'email' => $newEmail,
            ]);

        // Проверяем успешный ответ и наличие сообщения в JSON-ответе
        // assertJson(['message' => 'User updated successfully']); так можно проверять ответы
        $response->assertStatus(200)
            ->assertJson(['message' => 'User updated successfully']);
        // Проверяем, что данные пользователя были обновлены
        // Ищем юзера по старому id !!!!!!!!!!!!!
        $updatedUser = User::find($this->user->id);
        $this->assertEquals($newName, $updatedUser->name);
        $this->assertEquals($newEmail, $updatedUser->email);
    }

    public function testGetUserByIdOrEmail()
    {
        $statuses = config('ApiStatus');
        // Создаем тестового пользователя
        $this->user = User::factory()->create([
            'email' => 'test@example.com',
            'user_role' => 'manager',
        ]);

        // Вызываем метод с идентификатором пользователя
        $response = $this->actingAs($this->user, 'sanctum')
            ->get('api/sanctum/getUserByIdOrEmail/' . $this->user->id);
        
        // Проверяем успешный статус ответа
        $response->assertStatus(200);
        
        // Проверяем, что ответ содержит правильные данные пользователя
        $response->assertJson([
            'data' => [
                'id' => $this->user->id,
                'email' => $this->user->email,
            ],
            'message' => 'User founded successfully',
            'status' =>  $statuses['ok'],
        ]);
    }

    public function testGetUserByIdOrEmailWithWrongRole()
    {
        $statuses = config('ApiStatus');
        // Создаем тестового пользователя
        $this->user = User::factory()->create([
            'email' => 'test@example.com',
            'user_role' => 'master',
        ]);

        // Вызываем метод с идентификатором пользователя
        $response = $this->actingAs($this->user, 'sanctum')
            ->get('api/sanctum/getUserByIdOrEmail/' . $this->user->id);
        
        //Проверка на статус ответа
        $response->assertStatus(403);
        //Проверка на то что ответ в виде json
        $response->assertSee("You are not admin or manager!!!");
    }

    public function testGetUserByIdOrEmailByAdmin()
    {
        $statuses = config('ApiStatus');
        // Создаем тестового пользователя
        $this->user = User::factory()->create([
            'email' => 'test@example.com',
            'user_role' => 'admin',
        ]);

        // Вызываем метод с идентификатором пользователя
        $response = $this->actingAs($this->user, 'sanctum')
            ->get('api/sanctum/getUserByIdOrEmail/' . $this->user->id);
        
        // Проверяем успешный статус ответа
        $response->assertStatus(200);
        
        // Проверяем, что ответ содержит правильные данные пользователя
        $response->assertJson([
            'data' => [
                'id' => $this->user->id,
                'email' => $this->user->email,
            ],
            'message' => 'User founded successfully',
            'status' =>  $statuses['ok'],
        ]);
    }

    public function testGetUserByIdOrEmailEmptyID()
    {
        $statuses = config('ApiStatus');
        // Создаем тестового пользователя
        $this->user = User::factory()->create([
            'email' => 'test@example.com',
            'user_role' => 'manager',
        ]);

        // Вызываем метод с идентификатором пользователя
        $response = $this->actingAs($this->user, 'sanctum')
            ->get('api/sanctum/getUserByIdOrEmail/');
        
        // Проверяем успешный статус ответа
        $response->assertStatus(404);
    }

    public function testGetUserByIdOrEmailWithNotRealId()
    {
        $statuses = config('ApiStatus');
        // Создаем тестового пользователя
        $this->user = User::factory()->create([
            'email' => 'test@example.com',
            'user_role' => 'manager',
        ]);

        // Вызываем метод с идентификатором пользователя
        $response = $this->actingAs($this->user, 'sanctum')
            ->get('api/sanctum/getUserByIdOrEmail/' . ($this->user->id + 454));
        
        //Проверка на статус ответа
        $response->assertStatus(200);
        //Проверка на то ччто ответ в виде json
        $response->assertJson([
            "status" => "Warning",
            "message" => "User not found",
            "data" => ""
        ]);
    }

    public function testDeleteUserByIdOrEmail()
    {
        $statuses = config('ApiStatus');

        // Создаем тестового пользователя
        $this->user = User::factory()->create([
            'email' => 'test@example.com',
            'user_role' => 'manager',
        ]);

        // Вызываем метод с идентификатором пользователя
        $response =  $this->actingAs($this->user, 'sanctum')
            ->delete('api/sanctum/deleteUserByIdOrEmail/' . $this->user->id);
        
        // Проверяем успешный статус ответа
        $response->assertStatus(200);
        
        // Проверяем, что ответ содержит правильное сообщение и статус
        $response->assertJson([
            'message' => 'User deleted successfully',
            'status' => $statuses['ok'],
        ]);
        
        // Проверяем, что пользователь был удален из базы данных
        $this->assertDeleted($this->user);
    }

    public function testDeleteUserByIdOrEmailWithWrongRole()
    {
        $statuses = config('ApiStatus');

        // Создаем тестового пользователя
        $this->user = User::factory()->create([
            'email' => 'test@example.com',
            'user_role' => 'master',
        ]);

        // Вызываем метод с идентификатором пользователя
        $response =  $this->actingAs($this->user, 'sanctum')
            ->delete('api/sanctum/deleteUserByIdOrEmail/' . $this->user->id);
        
        //Проверка на статус ответа
        $response->assertStatus(403);
        //Проверка на то что ответ в виде json
        $response->assertSee("You are not admin or manager!!!");
    }

    public function testDeleteUserByIdOrEmailByAdmin()
    {
        $statuses = config('ApiStatus');

        // Создаем тестового пользователя
        $this->user = User::factory()->create([
            'email' => 'test@example.com',
            'user_role' => 'admin',
        ]);

        // Вызываем метод с идентификатором пользователя
        $response =  $this->actingAs($this->user, 'sanctum')
            ->delete('api/sanctum/deleteUserByIdOrEmail/' . $this->user->id);
        
        // Проверяем успешный статус ответа
        $response->assertStatus(200);
        
        // Проверяем, что ответ содержит правильное сообщение и статус
        $response->assertJson([
            'message' => 'User deleted successfully',
            'status' => $statuses['ok'],
        ]);
        
        // Проверяем, что пользователь был удален из базы данных
        $this->assertDeleted($this->user);
    }

    public function testDeleteUserById()
    {
        $statuses = config('ApiStatus');

        // Создаем тестового пользователя
        $this->user = User::factory()->create([
            'email' => 'test@example.com',
            'user_role' => 'manager',
        ]);

        // Вызываем метод с идентификатором пользователя
        $response =  $this->actingAs($this->user, 'sanctum')
            ->delete('api/sanctum/deleteUserByIdOrEmail/' . ($this->user->id + 3423));
        
        //Проверка на статус ответа
        $response->assertStatus(200);
        //Проверка на то ччто ответ в виде json
        $response->assertJson([
            "status" => "Warning",
            "message" => "User not found",
            "data" => ""
        ]);
    }

    public function testDeleteUserByEmail()
    {
        $statuses = config('ApiStatus');

        // Создаем тестового пользователя
        $this->user = User::factory()->create([
            'email' => 'test@example.com',
            'user_role' => 'manager',
        ]);

        // Вызываем метод с идентификатором пользователя
        $response =  $this->actingAs($this->user, 'sanctum')
            ->delete('api/sanctum/deleteUserByIdOrEmail/' . $this->user->email);
        
        // Проверяем успешный статус ответа
        $response->assertStatus(200);
        
        // Проверяем, что ответ содержит правильное сообщение и статус
        $response->assertJson([
            'message' => 'User deleted successfully',
            'status' => $statuses['ok'],
        ]);
        
        // Проверяем, что пользователь был удален из базы данных
        $this->assertDeleted($this->user);
    }

    public function testGetUsersByField()
    {
        $statuses = config('ApiStatus');

        // Создаем фейковые данные для запроса
        $data = [
            'user_role' => 'master',
            'name' => $this->faker->name,
        ];

        $newUser = User::factory()->create([
            'user_role' => 'master',
            'name' => $data['name'],
        ]);
        
        // Создаем тестового пользователя
        $this->user = User::factory()->create([
            'user_role' => 'manager',
        ]);

        // Вызываем метод с идентификатором пользователя
        $response = $this->actingAs($this->user, 'sanctum')
            ->post('api/sanctum/getUsersByField/', $data);
        
        // Проверяем успешный статус ответа
        $response->assertStatus(200);

        $response->assertJson([
            'status' => 'Successfully',
            'message' => 'Users founded successfully',
            'data' => [
                [
                    'name' => $data['name']
                ]
            ]
        ]);
    }
}
