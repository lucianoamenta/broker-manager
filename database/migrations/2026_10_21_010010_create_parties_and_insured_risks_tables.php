<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * BLOQUE 3: Clientes (Parties) Globales y Bienes / Personas Asegurables (Riesgos).
     */
    public function up(): void
    {
        // 1. Clientes / Participantes (Personas físicas o jurídicas globales del sistema)
        Schema::create('parties', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->nullable()->unique()->constrained('users')->nullOnDelete(); // Usuario de acceso para portal de clientes
            $table->boolean('is_individual')->default(true)->index(); // true: persona física | false: sociedad o persona jurídica (empresa)
            $table->string('first_name', 100)->nullable();
            $table->string('last_name', 100)->nullable();
            $table->string('legal_name', 200)->nullable(); // Razón social si es empresa
            $table->string('tax_id_type', 20)->default('cuit'); // cuit, cuil, dni, pasaporte
            $table->string('tax_id', 30)->unique(); // Número de CUIT / DNI único en la plataforma
            $table->foreignId('fiscal_condition_id')->nullable()->constrained('fiscal_conditions')->nullOnDelete();
            $table->foreignId('gender_id')->nullable()->constrained('genders')->nullOnDelete();
            $table->foreignId('marital_status_id')->nullable()->constrained('marital_statuses')->nullOnDelete();
            $table->date('birth_date')->nullable();
            $table->string('personal_email', 100)->nullable()->index();
            $table->string('personal_phone', 30)->nullable();
            $table->text('address')->nullable();
            $table->foreignId('city_id')->nullable()->constrained('cities')->nullOnDelete();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
            $table->softDeletes();
        });

        // 2. Catálogo de Tipos de Riesgo Asegurable (Vehículos, Inmuebles, Cauciones, Comercios, Personas)
        Schema::create('insured_risk_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('code', 50)->unique();
            $table->string('description', 255)->nullable();
        });

        // 3. Cabecera común de Riesgos Asegurables
        Schema::create('insured_risks', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('party_id')->nullable()->constrained('parties')->nullOnDelete(); // Titular o dueño del bien
            $table->foreignId('insured_risk_type_id')->constrained('insured_risk_types');
            $table->string('identifier', 100)->index(); // Patente, CUIT, DNI, dirección o número de contrato para búsqueda ágil
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
            $table->softDeletes();
        });

        // 3. Bienes: Vehículos Automotores
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('insured_risk_id')->constrained('insured_risks')->cascadeOnDelete();
            $table->string('license_plate', 20)->unique(); // Patente / Dominio
            $table->string('make', 100); // Marca (ej. Toyota, Volkswagen)
            $table->string('model', 100); // Modelo (ej. Hilux, Gol Trend)
            $table->string('version', 150)->nullable(); // Versión (ej. 2.8 DX 4x4 MT)
            $table->unsignedSmallInteger('year'); // Año fabricación
            $table->string('engine_number', 50)->nullable(); // Número de motor
            $table->string('chassis_number', 50)->nullable(); // Número de chasis / VIN
            $table->string('usage_type', 50)->default('particular'); // particular, comercial, taxi, remis, carga
            $table->boolean('gnc')->default(false); // Equipo de GNC instalado
            $table->boolean('is_zero_km')->default(false);
            $table->string('color', 50)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // 4. Bienes: Inmuebles (Hogar, Casas, Departamentos, Edificios)
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('insured_risk_id')->constrained('insured_risks')->cascadeOnDelete();
            $table->string('property_type', 50)->default('house'); // house, apartment, country, warehouse
            $table->text('address');
            $table->foreignId('city_id')->nullable()->constrained('cities')->nullOnDelete();
            $table->string('postal_code', 20)->nullable();
            $table->decimal('covered_surface_m2', 10, 2)->nullable(); // Superficie cubierta
            $table->string('construction_type', 100)->nullable(); // Material tradicional, seco, madera
            $table->text('security_measures')->nullable(); // Rejas, alarma monitoreada, matafuegos
            $table->timestamps();
            $table->softDeletes();
        });

        // 5. Garantías Contractuales: Seguros de Caución
        Schema::create('surety_bonds', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('insured_risk_id')->constrained('insured_risks')->cascadeOnDelete();
            $table->foreignId('beneficiary_party_id')->nullable()->constrained('parties')->nullOnDelete(); // Beneficiario/Asegurado de la garantía (ej: Propietario o Comitente)
            $table->string('guarantee_type', 50)->default('alquiler'); // alquiler, mantenimiento_oferta, ejecucion_contrato, fondo_reparo, aduanera
            $table->string('contract_number', 100)->nullable(); // Número de contrato de alquiler o licitación
            $table->text('contract_subject')->nullable(); // Objeto del contrato amparado
            $table->date('contract_start_date')->nullable();
            $table->date('contract_end_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // 6. Riesgos Comerciales (Negocios, Industrias, Depósitos)
        Schema::create('commercial_risks', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('insured_risk_id')->constrained('insured_risks')->cascadeOnDelete();
            $table->foreignId('business_activity_id')->nullable()->constrained('business_activities')->nullOnDelete();
            $table->string('trade_name', 150); // Nombre de fantasía del comercio
            $table->text('address');
            $table->foreignId('city_id')->nullable()->constrained('cities')->nullOnDelete();
            $table->decimal('surface_m2', 10, 2)->nullable();
            $table->decimal('declared_merchandise_value', 16, 2)->default(0.00); // Valor declarado de mercadería
            $table->timestamps();
            $table->softDeletes();
        });

        // 7. Personas Aseguradas (Vida individual, Accidentes Personales)
        Schema::create('insured_people', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('insured_risk_id')->constrained('insured_risks')->cascadeOnDelete();
            $table->foreignId('party_id')->nullable()->constrained('parties')->nullOnDelete();
            $table->string('occupation', 150)->nullable(); // Profesión u ocupación laboral
            $table->boolean('is_sports_practitioner')->default(false); // Práctica deportes de riesgo
            $table->boolean('has_preexisting_conditions')->default(false); // Declaración de salud
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insured_people');
        Schema::dropIfExists('commercial_risks');
        Schema::dropIfExists('surety_bonds');
        Schema::dropIfExists('properties');
        Schema::dropIfExists('vehicles');
        Schema::dropIfExists('insured_risks');
        Schema::dropIfExists('insured_risk_types');
        Schema::dropIfExists('parties');
    }
};
