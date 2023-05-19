<?php
// use App\Models\User;
// use Illuminate\Foundation\Testing\RefreshDatabase;
// use Illuminate\Foundation\Testing\WithFaker;
// use Tests\TestCase;

// class UserTest extends TestCase
// {
//     //Использует бд которая в .env описана как DB_TEST_продолжение, а в config/database.php как
//     //mysql_testing. Используется по дефолту потому что указана в config/database.php в параметре testing
//     //в качестве дефолтной.
//     //RefreshDatabase делает миграции с основной бд сюда
//     use RefreshDatabase;
    
//     public function testGetUsersList()
//     {
//         //Создает юзера по модели User
//         $user = User::factory()->create();
        
//         //Использует юзера, не использует явную авторизацию с токенами как в реале, а  юзает временные CSRF токены
//         $response = $this->actingAs($user, 'sanctum')
//             ->get('api/sanctum/getUsersList');
        
//         //Проверка на статус ответа
//         $response->assertStatus(200);
//         //Проверка на то ччто ответ в виде json
//         $response->assertJson(User::all()->toArray());
//     }
// }
