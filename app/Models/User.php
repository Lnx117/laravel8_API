<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @OA\Schema(
 *     schema="RegisterRequest",
 *     title="Регистрация нового пользователя",
 *     type="object",
 *     required={"name", "email", "password", "user_firstname", "user_lastname", "user_patronymic"},
 *     @OA\Property(property="name", type="string", example="Ivan", description="Имя пользователя"),
 *     @OA\Property(property="email", type="string", example="ivan@yandex.ru", format="email", description="Адрес электронной почты"),
 *     @OA\Property(property="password", type="string", example="12345678", format="password", description="Пароль пользователя (не менее 8 символов)"),
 *     @OA\Property(property="user_firstname", type="string", example="Владислав", description="Имя пользователя (не менее 3 символов)"),
 *     @OA\Property(property="user_lastname", type="string", example="Остряков", description="Фамилия пользователя (не менее 3 символов)"),
 *     @OA\Property(property="user_patronymic", type="string", example="Павлович", description="Отчество пользователя (не менее 3 символов)")
 * )
 *
* @OA\SecurityScheme(
*     type="http",
*     description="Login with email and password to get the authentication token",
*     name="Token based Based",
*     in="header",
*     scheme="bearer",
*     bearerFormat="JWT",
*     securityScheme="apiAuth",
* )
*/

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'user_role', 'user_status', 'user_firstname', 'user_lastname', 'user_patronymic',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
