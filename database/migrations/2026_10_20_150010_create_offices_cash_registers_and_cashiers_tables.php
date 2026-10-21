<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Tipos de Caja Registradora (Física, Virtual, Bancaria)
        Schema::create('cash_register_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('code', 30)->unique();
            $table->text('description')->nullable();
        });

        // 2. Oficinas (Sucursales operativas de cada zona)
        Schema::create('offices', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('zone_id')->constrained('zones')->cascadeOnDelete();
            $table->string('name', 150);
            $table->string('code', 50);
            $table->text('description')->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('email', 100)->nullable();
            $table->text('address')->nullable();
            $table->foreignId('city_id')->nullable()->constrained('cities')->nullOnDelete();
            $table->text('url_logo')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['zone_id', 'code']);
        });

        // 3. Representantes de Oficina (Responsables / Encargados de sucursal)
        Schema::create('office_representatives', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('office_id')->constrained('offices')->cascadeOnDelete();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->string('full_name', 200);
            $table->string('cuit', 20)->nullable();
            $table->string('personal_email', 100)->nullable();
            $table->string('personal_phone', 30)->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
            $table->softDeletes();
        });

        // 4. Cajas Registradoras por Oficina
        Schema::create('cash_registers', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('office_id')->constrained('offices')->cascadeOnDelete();
            $table->foreignId('cash_register_type_id')->constrained('cash_register_types')->restrictOnDelete();
            $table->string('name', 100);
            $table->string('code', 50);
            $table->decimal('balance', 16, 2)->default(0.00);
            $table->boolean('is_open')->default(false)->index();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['office_id', 'code']);
        });

        // 5. Cajeros asignados a la Oficina
        Schema::create('cashiers', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('office_id')->constrained('offices')->cascadeOnDelete();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->string('full_name', 200);
            $table->string('personal_email', 100)->nullable();
            $table->string('personal_phone', 30)->nullable();
            $table->string('cuit', 20)->nullable();
            $table->text('address')->nullable();
            $table->foreignId('city_id')->nullable()->constrained('cities')->nullOnDelete();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cashiers');
        Schema::dropIfExists('cash_registers');
        Schema::dropIfExists('office_representatives');
        Schema::dropIfExists('offices');
        Schema::dropIfExists('cash_register_types');
    }
};
