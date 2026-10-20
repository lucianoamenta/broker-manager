<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {

        Schema::create('employee_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('code', 20)->unique();
            $table->text('description')->nullable();
        });

        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('names', 200);
            $table->string('surnames', 200);
            $table->string('personal_phone', 20)->nullable();
            $table->string('personal_email', 100)->nullable();
            $table->string('cuit', 20)->nullable();
            $table->text('address')->nullable();
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('gender_id');
            $table->unsignedBigInteger('marital_status_id');
            $table->unsignedBigInteger('employee_type_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('gender_id')->references('id')->on('genders');
            $table->foreign('marital_status_id')->references('id')->on('marital_statuses');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('employee_type_id')->references('id')->on('employee_types');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_types');
        Schema::dropIfExists('employees');
    }
};
