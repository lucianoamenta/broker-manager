<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * BLOQUE 6: Documentos y Archivos Adjuntos Específicos por Entidad (Tipos y Archivos Versionados).
     */
    public function up(): void
    {
        // 1. ORGANIZATIONS FILES
        Schema::create('organization_file_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('code', 50)->unique();
            $table->text('description')->nullable();
            $table->integer('max_size_mb')->default(10);
            $table->json('accepted_formats')->nullable();
            $table->timestamps();
        });

        Schema::create('organization_files', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('organization_id')->constrained('organizations')->cascadeOnDelete();
            $table->foreignId('organization_file_type_id')->constrained('organization_file_types')->cascadeOnDelete();
            $table->text('url');
            $table->text('original_name')->nullable();
            $table->integer('version')->default(1);
            $table->foreignId('uploaded_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        // 2. ZONES FILES
        Schema::create('zone_file_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('code', 50)->unique();
            $table->text('description')->nullable();
            $table->integer('max_size_mb')->default(10);
            $table->json('accepted_formats')->nullable();
            $table->timestamps();
        });

        Schema::create('zone_files', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('zone_id')->constrained('zones')->cascadeOnDelete();
            $table->foreignId('zone_file_type_id')->constrained('zone_file_types')->cascadeOnDelete();
            $table->text('url');
            $table->text('original_name')->nullable();
            $table->integer('version')->default(1);
            $table->foreignId('uploaded_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        // 3. DEPARTMENTS FILES
        Schema::create('department_file_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('code', 50)->unique();
            $table->text('description')->nullable();
            $table->integer('max_size_mb')->default(10);
            $table->json('accepted_formats')->nullable();
            $table->timestamps();
        });

        Schema::create('department_files', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('department_id')->constrained('departments')->cascadeOnDelete();
            $table->foreignId('department_file_type_id')->constrained('department_file_types')->cascadeOnDelete();
            $table->text('url');
            $table->text('original_name')->nullable();
            $table->integer('version')->default(1);
            $table->foreignId('uploaded_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        // 4. OFFICES FILES
        Schema::create('office_file_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('code', 50)->unique();
            $table->text('description')->nullable();
            $table->integer('max_size_mb')->default(10);
            $table->json('accepted_formats')->nullable();
            $table->timestamps();
        });

        Schema::create('office_files', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('office_id')->constrained('offices')->cascadeOnDelete();
            $table->foreignId('office_file_type_id')->constrained('office_file_types')->cascadeOnDelete();
            $table->text('url');
            $table->text('original_name')->nullable();
            $table->integer('version')->default(1);
            $table->foreignId('uploaded_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        // 5. INSURERS FILES (Contratos marco, resoluciones de SSN, manuales operativos)
        Schema::create('insurer_file_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('code', 50)->unique();
            $table->text('description')->nullable();
            $table->integer('max_size_mb')->default(15);
            $table->json('accepted_formats')->nullable();
            $table->timestamps();
        });

        Schema::create('insurer_files', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('insurer_id')->constrained('insurers')->cascadeOnDelete();
            $table->foreignId('insurer_file_type_id')->constrained('insurer_file_types')->cascadeOnDelete();
            $table->text('url');
            $table->text('original_name')->nullable();
            $table->integer('version')->default(1);
            $table->foreignId('uploaded_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        // 6. PAS REGISTRATIONS FILES (Credencial SSN, Matrícula CIPAS, Seguro de Caución PAS)
        Schema::create('pas_registration_file_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('code', 50)->unique();
            $table->text('description')->nullable();
            $table->integer('max_size_mb')->default(10);
            $table->json('accepted_formats')->nullable();
            $table->timestamps();
        });

        Schema::create('pas_registration_files', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('pas_registration_id')->constrained('pas_registrations')->cascadeOnDelete();
            $table->foreignId('pas_registration_file_type_id')->constrained('pas_registration_file_types')->cascadeOnDelete();
            $table->text('url');
            $table->text('original_name')->nullable();
            $table->integer('version')->default(1);
            $table->foreignId('uploaded_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        // 7. QUOTES FILES (Fotos de inspección previa, cotización PDF de aseguradora, formulario de solicitud)
        Schema::create('quote_file_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('code', 50)->unique();
            $table->text('description')->nullable();
            $table->integer('max_size_mb')->default(15);
            $table->json('accepted_formats')->nullable();
            $table->timestamps();
        });

        Schema::create('quote_files', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('quote_id')->constrained('quotes')->cascadeOnDelete();
            $table->foreignId('quote_file_type_id')->constrained('quote_file_types')->cascadeOnDelete();
            $table->text('url');
            $table->text('original_name')->nullable();
            $table->integer('version')->default(1);
            $table->foreignId('uploaded_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        // 8. POLICIES FILES (Frente de póliza oficial, certificado de cobertura, cláusulas particulares)
        Schema::create('policy_file_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('code', 50)->unique();
            $table->text('description')->nullable();
            $table->integer('max_size_mb')->default(25);
            $table->json('accepted_formats')->nullable();
            $table->timestamps();
        });

        Schema::create('policy_files', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('policy_id')->constrained('policies')->cascadeOnDelete();
            $table->foreignId('policy_file_type_id')->constrained('policy_file_types')->cascadeOnDelete();
            $table->text('url');
            $table->text('original_name')->nullable();
            $table->integer('version')->default(1);
            $table->foreignId('uploaded_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        // 9. PAYMENTS FILES (Comprobante de transferencia bancaria, foto de cheque, cupón POSNET)
        Schema::create('payment_file_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('code', 50)->unique();
            $table->text('description')->nullable();
            $table->integer('max_size_mb')->default(10);
            $table->json('accepted_formats')->nullable();
            $table->timestamps();
        });

        Schema::create('payment_files', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('payment_id')->constrained('payments')->cascadeOnDelete();
            $table->foreignId('payment_file_type_id')->constrained('payment_file_types')->cascadeOnDelete();
            $table->text('url');
            $table->text('original_name')->nullable();
            $table->integer('version')->default(1);
            $table->foreignId('uploaded_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        // 10. CASH MOVEMENTS FILES (Factura de servicio pagado con caja, comprobante de depósito bancario / remesa)
        Schema::create('cash_movement_file_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('code', 50)->unique();
            $table->text('description')->nullable();
            $table->integer('max_size_mb')->default(10);
            $table->json('accepted_formats')->nullable();
            $table->timestamps();
        });

        Schema::create('cash_movement_files', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('cash_movement_id')->constrained('cash_movements')->cascadeOnDelete();
            $table->foreignId('cash_movement_file_type_id')->constrained('cash_movement_file_types')->cascadeOnDelete();
            $table->text('url');
            $table->text('original_name')->nullable();
            $table->integer('version')->default(1);
            $table->foreignId('uploaded_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_movement_files');
        Schema::dropIfExists('cash_movement_file_types');
        Schema::dropIfExists('payment_files');
        Schema::dropIfExists('payment_file_types');
        Schema::dropIfExists('policy_files');
        Schema::dropIfExists('policy_file_types');
        Schema::dropIfExists('quote_files');
        Schema::dropIfExists('quote_file_types');
        Schema::dropIfExists('pas_registration_files');
        Schema::dropIfExists('pas_registration_file_types');
        Schema::dropIfExists('insurer_files');
        Schema::dropIfExists('insurer_file_types');
        Schema::dropIfExists('office_files');
        Schema::dropIfExists('office_file_types');
        Schema::dropIfExists('department_files');
        Schema::dropIfExists('department_file_types');
        Schema::dropIfExists('zone_files');
        Schema::dropIfExists('zone_file_types');
        Schema::dropIfExists('organization_files');
        Schema::dropIfExists('organization_file_types');
    }
};
