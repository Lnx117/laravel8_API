<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applications extends Model
{
    use HasFactory;
    protected $table = 'applications';

    protected $fillable = [
        'customer_first_name', 'customer_last_name', 'customer_patronymic', 'customer_phone', 'app_city', 'app_street',
        'app_house_number', 'app_house_building', 'app_flat_num','app_floor_num', 'app_house_entrance', 'app_created_at',
        'app_to_execute_at', 'problem_text', 'master_id','app_status', 'bitrix_customer_id',
    ];

    protected $attributes = [
        'master_id' => null,
    ];
}
