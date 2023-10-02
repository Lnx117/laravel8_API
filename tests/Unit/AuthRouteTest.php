<?php
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthRouteTest extends TestCase
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
    
    //Проверка роута регистрации пользователя
    public function testRegister()
    {
        $statuses = config('ApiStatus');

        $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password',
            'user_role' => 'master',
            'user_firstname' => $this->faker->name,
            'user_lastname' => $this->faker->name,
            'user_patronymic' => $this->faker->name,
        ];

        $response = $this->postJson('api/sanctum/register', $userData);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => $statuses['ok'],
            'message' => 'New user token',
        ]);

        // Проверяем, что пользователь создан в базе данных
        $this->assertDatabaseHas('users', [
            'email' => $userData['email'],
        ]);
    }

    //Проверка роута регистрации пользователя с ошибками валидации
    //Короткие данные в запросе
    public function testRegisterTooShort()
    {
        $statuses = config('ApiStatus');

        $userData = [
            'name' => "",
            'email' => "i",
            'password' => "i",
            'user_role' => "master",
            'user_firstname' => "i",
            'user_lastname' => "i",
            'user_patronymic' => "i",
        ];

        $response = $this->postJson('api/sanctum/register', $userData);

        //Проверка статуса неавторизован
        $response->assertStatus(401);
        $response->assertJson([
            "error" => [
                "name" => [
                  "The name field is required."
                ],
                "email" => [
                  "The email must be a valid email address."
                ],
                "password" => [
                  "The password must be at least 8 characters."
                ],
                "user_firstname" => [
                  "The user firstname must be at least 3 characters."
                ],
                "user_lastname" => [
                  "The user lastname must be at least 3 characters."
                ],
                "user_patronymic" => [
                  "The user patronymic must be at least 3 characters."
                ]
            ]
        ]);
    }

    //Проверка роута регистрации пользователя с ошибками валидации
    //Пустой запрос с рег данными
    public function testRegisterEmptyData()
    {
        $statuses = config('ApiStatus');

        $userData = [

        ];

        $response = $this->postJson('api/sanctum/register', $userData);

        //Проверка статуса неавторизован
        $response->assertStatus(401);
        $response->assertJson([
            "error" => [
                "name" => [
                    "The name field is required."
                ],
                "email" => [
                    "The email field is required."
                ],
                "password" => [
                    "The password field is required."
                ],
                "user_firstname" => [
                    "The user firstname field is required."
                ],
                "user_lastname" => [
                    "The user lastname field is required."
                ],
                "user_patronymic" => [
                    "The user patronymic field is required."
                ]
            ]
        ]);
    }

    //Получение токена по логину и паролю
    public function testToken()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $requestData = [
            'email' => 'test@example.com',
            'password' => 'password',
        ];

        $response = $this->postJson('api/sanctum/token', $requestData);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'token',
        ]);

        // Проверяем, что токен создан у пользователя
        $this->assertDatabaseHas('personal_access_tokens', [
            'tokenable_id' => $user->id,
            'tokenable_type' => User::class,
        ]);
    }

    //Получение токена по логину и паролю
    //Неверные данные
    public function testTokenWrongData()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $requestData = [
            'email' => 'testTTTTTTTT@example.com',
            'password' => 'passwoererrd',
        ];

        $response = $this->postJson('api/sanctum/token', $requestData);

        $response->assertStatus(401);
        $response->assertJson([
            "error" => "The provided credentials are incorrect."
        ]);
    }

    //Получение токена по логину и паролю
    //Пустые данные
    public function testTokenEmptyData()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $requestData = [

        ];

        $response = $this->postJson('api/sanctum/token', $requestData);

        $response->assertStatus(401);
        $response->assertJson([
            "error" => [
                "email" => [
                  "The email field is required."
                ],
                "password" => [
                  "The password field is required."
                ]
            ]
        ]);
    }

    //Проверка регистрации мастера
    //Может только админ
    public function testRegisterManager()
    {
        $statuses = config('ApiStatus');

        // Создаем пользователя с ролью 'admin' для выполнения запроса
        $admin = User::factory()->create([
            'user_role' => 'admin',
        ]);

        // Создаем данные для запроса
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password',
        ];

        // Отправляем POST-запрос на /sanctum/registerManager с данными и токеном аутентификации админа
        $response = $this->actingAs($admin)->postJson('api/sanctum/registerManager', $data);

        // Проверяем, что ответ имеет статус 200 (Успех)
        $response->assertStatus(200);

        // Проверяем, что ответ содержит ожидаемые данные
        $response->assertJson([
            'status' => $statuses['ok'],
            'message' => 'New manager token',
            // Дополнительные проверки данных, если необходимо
        ]);

        // Проверяем, что создан новый пользователь с ролью 'manager'
        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'user_role' => 'manager',
        ]);
    }

    //Проверка регистрации мастера
    //Попытка зарегистрировать будучи не админом
    public function testRegisterManagerNotAdmin()
    {
        $statuses = config('ApiStatus');

        // Создаем пользователя с ролью 'admin' для выполнения запроса
        $admin = User::factory()->create([
            'user_role' => 'manager',
        ]);

        // Создаем данные для запроса
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password',
        ];

        // Отправляем POST-запрос на /sanctum/registerManager с данными и токеном аутентификации админа
        $response = $this->actingAs($admin)->postJson('api/sanctum/registerManager', $data);

        // Проверяем, что ответ имеет статус 403
        $response->assertStatus(403);

        // Проверяем, что ответ содержит ожидаемые данные (мидлвар не дает зарегистрировать)
        $response->assertSee("You are not admin!!!");
    }

    //Проверка регистрации мастера
    //Попытка зарегистрировать будучи админом, но спустыми данными
    public function testRegisterManagerEmptyData()
    {
        $statuses = config('ApiStatus');

        // Создаем пользователя с ролью 'admin' для выполнения запроса
        $admin = User::factory()->create([
            'user_role' => 'admin',
        ]);

        // Создаем данные для запроса
        $data = [

        ];

        // Отправляем POST-запрос на /sanctum/registerManager с данными и токеном аутентификации админа
        $response = $this->actingAs($admin)->postJson('api/sanctum/registerManager', $data);

        // Проверяем, что ответ имеет статус 200
        $response->assertStatus(200);

        // Проверяем, что ответ содержит ожидаемые данные
        $response->assertJson([
            "status" => "Warning",
            "message" => "Register validation failed",
            "data" => ""
        ]);
    }

    //Проверка регистрации мастера
    //Попытка зарегистрировать будучи админом, но некорректыми данными
    public function testRegisterManagerNotValidData()
    {
        $statuses = config('ApiStatus');

        // Создаем пользователя с ролью 'admin' для выполнения запроса
        $admin = User::factory()->create([
            'user_role' => 'admin',
        ]);

        // Создаем данные для запроса
        $data = [
            'name' => 'i',
            'email' => 'i',
            'password' => 'i',
        ];

        // Отправляем POST-запрос на /sanctum/registerManager с данными и токеном аутентификации админа
        $response = $this->actingAs($admin)->postJson('api/sanctum/registerManager', $data);

        // Проверяем, что ответ имеет статус 200
        $response->assertStatus(200);

        // Проверяем, что ответ содержит ожидаемые данные
        $response->assertJson([
            "status" => "Warning",
            "message" => "Register validation failed",
            "data" => ""
        ]);
    }
}
