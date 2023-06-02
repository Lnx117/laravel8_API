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
    
    public function testRegister()
    {
        $statuses = config('ApiStatus');

        $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password',
            'user_role' => 'admin',
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

}
