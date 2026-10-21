<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * BLOQUE 2: Compañías Aseguradoras, Ramos, Productos, Coberturas, Matrículas PAS y Convenios.
     */
    public function up(): void
    {
        // 1. Compañías Aseguradoras (La Segunda, San Cristóbal, Sancor, etc.)
        Schema::create('insurers', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name', 150);
            $table->string('legal_name', 200)->nullable();
            $table->string('cuit', 20)->nullable()->index();
            $table->string('code', 50)->unique();
            $table->string('ssn_code', 50)->nullable(); // Código oficial en Superintendencia de Seguros de la Nación
            $table->string('email', 100)->nullable();
            $table->string('phone', 30)->nullable();
            $table->text('web_url')->nullable();
            $table->text('url_logo')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->json('settings')->nullable(); // Configuración de APIs / web services / credenciales
            $table->timestamps();
            $table->softDeletes();
        });

        // 2. Ramos de Seguro (Automotores, Hogar, Vida, Accidentes Personales, Caución, etc.)
        Schema::create('insurance_branches', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name', 100);
            $table->string('code', 50)->unique();
            $table->text('description')->nullable();
            $table->string('icon', 50)->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
            $table->softDeletes();
        });

        // 3. Productos Comerciales de Seguro (ej.: Auto Total, Hogar Seguro, Caución Alquiler)
        Schema::create('insurance_products', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('insurer_id')->constrained('insurers')->cascadeOnDelete();
            $table->foreignId('insurance_branch_id')->constrained('insurance_branches')->cascadeOnDelete();
            $table->string('name', 150);
            $table->string('code', 50);
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['insurer_id', 'code']);
        });

        // 4. Catálogo de Coberturas Base (Responsabilidad Civil, Robo, Incendio, Granizo, etc.)
        Schema::create('coverage_definitions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('insurance_branch_id')->constrained('insurance_branches')->cascadeOnDelete();
            $table->string('name', 150);
            $table->string('code', 50);
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['insurance_branch_id', 'code']);
        });

        // 5. Matrículas de Productores Asesores de Seguros (PAS)
        Schema::create('pas_registrations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->nullable()->unique()->constrained('users')->nullOnDelete();
            $table->string('full_name', 200);
            $table->string('cuit', 20)->nullable()->index();
            $table->string('registration_number', 50)->unique(); // Número oficial de Matrícula SSN
            $table->boolean('is_individual')->default(true); // true: persona física, false: sociedad/empresa
            $table->string('email', 100)->nullable();
            $table->string('phone', 30)->nullable();
            $table->text('address')->nullable();
            $table->foreignId('city_id')->nullable()->constrained('cities')->nullOnDelete();
            $table->date('valid_from')->nullable();
            $table->date('valid_until')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
            $table->softDeletes();
        });

        // 6. Asignaciones Operativas de PAS a Organizaciones o Zonas
        Schema::create('organization_pas_assignments', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('organization_id')->constrained('organizations')->cascadeOnDelete();
            $table->foreignId('pas_registration_id')->constrained('pas_registrations')->cascadeOnDelete();
            $table->foreignId('zone_id')->nullable()->constrained('zones')->nullOnDelete(); // Zona territorial asignada (opcional)
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['organization_id', 'pas_registration_id', 'zone_id'], 'org_pas_zone_unique');
        });

        // 7. Aseguradoras habilitadas a nivel Organización
        Schema::create('organization_insurers', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('organization_id')->constrained('organizations')->cascadeOnDelete();
            $table->foreignId('insurer_id')->constrained('insurers')->cascadeOnDelete();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['organization_id', 'insurer_id']);
        });

        // 8. Aseguradoras habilitadas a nivel Zona (debe estar habilitada primero en la organización)
        Schema::create('zone_insurers', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('zone_id')->constrained('zones')->cascadeOnDelete();
            $table->foreignId('insurer_id')->constrained('insurers')->cascadeOnDelete();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['zone_id', 'insurer_id']);
        });

        // 9. Convenios Comerciales con Aseguradoras (Broker / PAS con Compañía)
        Schema::create('insurer_agreements', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('organization_id')->constrained('organizations')->cascadeOnDelete();
            $table->foreignId('insurer_id')->constrained('insurers')->cascadeOnDelete();
            $table->foreignId('pas_registration_id')->nullable()->constrained('pas_registrations')->nullOnDelete();
            $table->string('agreement_number', 50); // Número de código de productor o convenio con la aseguradora
            $table->date('valid_from')->nullable();
            $table->date('valid_until')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['organization_id', 'insurer_id', 'agreement_number'], 'org_insurer_agreement_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insurer_agreements');
        Schema::dropIfExists('zone_insurers');
        Schema::dropIfExists('organization_insurers');
        Schema::dropIfExists('organization_pas_assignments');
        Schema::dropIfExists('pas_registrations');
        Schema::dropIfExists('coverage_definitions');
        Schema::dropIfExists('insurance_products');
        Schema::dropIfExists('insurance_branches');
        Schema::dropIfExists('insurers');
    }
};
