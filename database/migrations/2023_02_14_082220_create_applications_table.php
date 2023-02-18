<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id');
            $table->string('customer_first_name');
            $table->string('customer_last_name');
            $table->string('customer_patronymic');
            $table->string('customer_phone');
            $table->string('app_city');
            $table->string('app_street');
            $table->string('app_house_number');
            $table->string('app_house_building');
            $table->string('app_flat_num');
            $table->string('app_floor_num');
            $table->string('app_house_entrance');
            $table->dateTime('app_created_at', $precision = 0);
            $table->dateTime('app_to_execute_at', $precision = 0);
            $table->string('master_id');
            $table->string('app_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applications');
    }
}
