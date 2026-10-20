<?php

use App\Models\Device;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {

            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('username', 50)->nullable();
            $table->boolean('is_verified')->default(true);
            $table->boolean('is_allowed')->default(true);
            $table->string('verification_token', 200)->nullable();
            $table->string('profile_picture', 800)->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
            $table->softDeletes();

            // Índice individual para created_at (SIEMPRE necesario)
            $table->index('created_at');
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('ip_address', 50)->nullable();
            $table->string('last_ip_used', 50)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('type', 10)->default(Device::SESION_EN_DEVICE_TIPO_API);
            $table->string('auth_token', 600);
            $table->string('fcm_token', 300)->nullable();
            $table->string('device_platform', 300)->nullable();
            $table->string('device_platform_version', 200)->nullable();
            $table->string('device_sdk', 100)->nullable();
            $table->string('device_brand', 100)->nullable();
            $table->string('device_model', 100)->nullable();
            $table->text('client_public_key')->nullable();
            $table->string('public_key_fingerprint', 64)->nullable()->comment('SHA-256 fingerprint of public key');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');

            // Índice individual para created_at (SIEMPRE necesario)
            $table->index('created_at');
            $table->index('public_key_fingerprint');
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('title', 100)->nullable();
            $table->text('body')->nullable();
            $table->text('description')->nullable();
            $table->text('payload')->nullable();
            $table->string('event', 100)->nullable();
            $table->text('url_image')->nullable();
            $table->boolean('is_read')->default(false);
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');

            $table->index('created_at');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('devices');
        Schema::dropIfExists('notifications');
    }
};
