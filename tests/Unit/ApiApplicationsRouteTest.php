<?php
use App\Models\User;
use App\Models\Applications;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiApplicationsRouteTest extends TestCase
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
    protected $app;
    
    public function testGetApplicationsList()
    {
        $statuses = config('ApiStatus');

        //Создает юзера по модели User
        $this->user = User::factory()->create([
            'user_role' => 'manager',
        ]);
        
        //Использует юзера, не использует явную авторизацию с токенами как в реале, а  юзает временные CSRF токены
        $response = $this->actingAs($this->user, 'sanctum')
            ->get('api/sanctum/getApplicationsList');
        
        //Проверка на статус ответа
        $response->assertStatus(200);
        //Проверка на то ччто ответ в виде json
        $response->assertJson([
            'message' => 'All apps',
            'status' =>  $statuses['ok'],
        ]);
    }

    public function testUpdateApplicationById()
    {
        // Используем старого юзера из свойства protected $user;
        $this->user = User::factory()->create([
            'user_role' => 'manager',
        ]);

        //$this->app = Applications::factory()->create();
        $app = Applications::factory()->create();
        // Создаем фейковые данные для запроса
        $data = [
            'bitrix_customer_id' => $this->faker->randomNumber(),
            'customer_first_name' => $this->faker->firstName,
            'customer_last_name' => $this->faker->lastName,
        ];

        // Выполняем запрос на обновление пользователя
        //Важно как мы указываем параметр в строке это ID или Email
        //а пост данные второй переменной
        $response = $this->actingAs($this->user, 'sanctum')
            ->put('api/sanctum/updateApplicationById/'.$app->id, [
                'bitrix_customer_id' => $data['bitrix_customer_id'],
                'customer_first_name' => $data['customer_first_name'],
                'customer_last_name' => $data['customer_last_name'],
            ]);

        // Проверяем успешный ответ и наличие сообщения в JSON-ответе
        // assertJson(['message' => 'User updated successfully']); так можно проверять ответы
        $response->assertStatus(200)
            ->assertJson(['message' => 'App updated successfully']);
        // Проверяем, что данные пользователя были обновлены
        // Ищем юзера по старому id !!!!!!!!!!!!!
        $updatedApp = Applications::find($app->id);
        $this->assertEquals($data['bitrix_customer_id'], $updatedApp->bitrix_customer_id);
        $this->assertEquals($data['customer_first_name'], $updatedApp->customer_first_name);
        $this->assertEquals($data['customer_last_name'], $updatedApp->customer_last_name);
    }


    public function testGetApplicationById()
    {
        $statuses = config('ApiStatus');
        // Создаем тестового пользователя
        $this->user = User::factory()->create([
            'user_role' => 'manager',
        ]);

        $app = Applications::factory()->create();

        // Вызываем метод с идентификатором пользователя
        $response = $this->actingAs($this->user, 'sanctum')
            ->get('api/sanctum/getApplicationById/' . $app->id);
        
        // Проверяем успешный статус ответа
        $response->assertStatus(200);
        
        // Проверяем, что ответ содержит правильные данные пользователя
        $response->assertJson([
            'data' => [
                'bitrix_customer_id' => $app->bitrix_customer_id,
                'customer_first_name' => $app->customer_first_name,
                'customer_last_name' => $app->customer_last_name,
            ],
            'message' => 'App founded successfully',
            'status' =>  $statuses['ok'],
        ]);
    }

    public function testDeleteApplicationById()
    {
        $statuses = config('ApiStatus');

        // Создаем тестового пользователя
        $this->user = User::factory()->create([
            'user_role' => 'manager',
        ]);

        $app = Applications::factory()->create();

        // Вызываем метод с идентификатором пользователя
        $response =  $this->actingAs($this->user, 'sanctum')
            ->delete('api/sanctum/deleteApplicationById/' . $app->id);
        
        // Проверяем успешный статус ответа
        $response->assertStatus(200);
        
        // Проверяем, что ответ содержит правильное сообщение и статус
        $response->assertJson([
            'message' => 'App deleted successfully',
            'status' => $statuses['ok'],
        ]);
        
        // Проверяем, что пользователь был удален из базы данных
        $this->assertDeleted($app);
    }

    public function testCreateTask()
    {
        $statuses = config('ApiStatus');

        // Создаем тестового пользователя
        $this->user = User::factory()->create([
            'user_role' => 'manager',
        ]);

        // Создаем фейковые данные для запроса
        $data = [
            'bitrix_customer_id' => $this->faker->randomNumber(),
            'customer_first_name' => $this->faker->firstName,
            'customer_last_name' => $this->faker->lastName,
            'customer_patronymic' => $this->faker->firstNameMale,
            'customer_phone' => $this->faker->phoneNumber,
            'app_city' => $this->faker->city,
            'app_street' => $this->faker->streetName,
            'app_house_number' => $this->faker->buildingNumber,
            'app_house_building' => $this->faker->secondaryAddress,
            'app_flat_num' => $this->faker->randomNumber(4),
            'app_floor_num' => $this->faker->randomNumber(2),
            'problem_text' => $this->faker->randomNumber(2),
            'app_house_entrance' => $this->faker->randomLetter,
            'app_status' => $this->faker->randomElement(['Принято', 'В работе', 'Завершено']),
        ];

        // Вызываем метод с идентификатором пользователя
        $response = $this->actingAs($this->user, 'sanctum')
            ->post("api/sanctum/createApplication/", $data);
        // Проверяем успешный статус ответа
        $response->assertStatus(200);

        // Проверяем, что заявка создана успешно
        $response->assertJson([
            'message' => 'Application created successfully',
            'status' => $statuses['ok'],
        ]);

        // Проверяем, что заявка сохранена в базе данных
        $this->assertDatabaseHas('applications', [
            'bitrix_customer_id' => $data['bitrix_customer_id'],
            'customer_first_name' => $data['customer_first_name'],
        ]);
    }
}
