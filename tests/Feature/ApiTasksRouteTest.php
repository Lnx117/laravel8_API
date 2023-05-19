<?php
use App\Models\User;
use App\Models\Tasks;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiTasksRouteTest extends TestCase
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
    protected $task;
    
    public function testGetTasksList()
    {
        $statuses = config('ApiStatus');

        //Создает юзера по модели User
        $this->user = User::factory()->create();
        
        //Использует юзера, не использует явную авторизацию с токенами как в реале, а  юзает временные CSRF токены
        $response = $this->actingAs($this->user, 'sanctum')
            ->get('api/sanctum/getTasksList');
        
        //Проверка на статус ответа
        $response->assertStatus(200);
        //Проверка на то ччто ответ в виде json
        $response->assertJson([
            'message' => 'All tasks',
            'status' =>  $statuses['ok'],
        ]);
    }

    public function testUpdateTaskById()
    {
        // Используем старого юзера из свойства protected $user;
        $this->user = User::factory()->create();

        $this->task = Tasks::factory()->create();
        // Генерируем новые данные для обновления
        $newStatus = $this->faker->name;
        $newAppId = $this->faker->unique()->randomNumber(2);
        $newMasterId = $this->faker->unique()->randomNumber(2);
        // Выполняем запрос на обновление пользователя
        //Важно как мы указываем параметр в строке это ID или Email
        //а пост данные второй переменной
        $response = $this->actingAs($this->user, 'sanctum')
            ->put('api/sanctum/updateTaskById/'.$this->task->id, [
                'application_id' => $newAppId,
                'master_id' => $newMasterId,
                'status' => $newStatus,
            ]);

        // Проверяем успешный ответ и наличие сообщения в JSON-ответе
        // assertJson(['message' => 'User updated successfully']); так можно проверять ответы
        $response->assertStatus(200)
            ->assertJson(['message' => 'Task updated successfully']);
        // Проверяем, что данные пользователя были обновлены
        // Ищем юзера по старому id !!!!!!!!!!!!!
        $updatedTask = Tasks::find($this->task->id);
        $this->assertEquals($newStatus, $updatedTask->status);
        $this->assertEquals($newAppId, $updatedTask->application_id);
        $this->assertEquals($newMasterId, $updatedTask->master_id);
    }


    public function testGetTaskById()
    {
        $statuses = config('ApiStatus');
        // Создаем тестового пользователя
        $this->user = User::factory()->create([
            'email' => 'test@example.com',
        ]);

        $this->task = Tasks::factory()->create();

        // Вызываем метод с идентификатором пользователя
        $response = $this->actingAs($this->user, 'sanctum')
            ->get('api/sanctum/getTaskById/' . $this->task->id);
        
        // Проверяем успешный статус ответа
        $response->assertStatus(200);
        
        // Проверяем, что ответ содержит правильные данные пользователя
        $response->assertJson([
            'data' => [
                'id' => $this->task->id,
                'application_id' => $this->task->application_id,
                'master_id' => $this->task->master_id,
            ],
            'message' => 'Task founded successfully',
            'status' =>  $statuses['ok'],
        ]);
    }

    public function testDeleteTaskById()
    {
        $statuses = config('ApiStatus');

        // Создаем тестового пользователя
        $this->user = User::factory()->create([
            'email' => 'test@example.com',
        ]);

        $this->task = Tasks::factory()->create();

        // Вызываем метод с идентификатором пользователя
        $response =  $this->actingAs($this->user, 'sanctum')
            ->delete('api/sanctum/deleteTaskById/' . $this->task->id);
        
        // Проверяем успешный статус ответа
        $response->assertStatus(200);
        
        // Проверяем, что ответ содержит правильное сообщение и статус
        $response->assertJson([
            'message' => 'Task deleted successfully',
            'status' => $statuses['ok'],
        ]);
        
        // Проверяем, что пользователь был удален из базы данных
        $this->assertDeleted($this->task);
    }

    public function testCreateTask()
    {
        $statuses = config('ApiStatus');

        // Создаем тестового пользователя
        $this->user = User::factory()->create([
            'email' => 'test@example.com',
        ]);

        $newAppId = $this->faker->unique()->randomNumber(2);
        $newMasterId = $this->faker->unique()->randomNumber(2);
        $newStatus = $this->faker->name;

        // Вызываем метод с идентификатором пользователя
        $response = $this->actingAs($this->user, 'sanctum')
            ->get("api/sanctum/createTask/{$newAppId}/{$newMasterId}/{$newStatus}");
        
        // Проверяем успешный статус ответа
        $response->assertStatus(200);

        $responseData = $response->json();
        $newTaskId = $responseData['data']['id'];
        $task = Tasks::find($newTaskId);
        $this->assertNotNull($task);

        // Проверяем, что ответ содержит правильное сообщение и статус
        $response->assertJson([
            'data' => [
                'application_id' => $newAppId,
                'master_id' => $newMasterId,
                'status' => $newStatus,
            ],
            'message' => 'Task created successfully',
            'status' => $statuses['ok'],
        ]);
        
    }
}
