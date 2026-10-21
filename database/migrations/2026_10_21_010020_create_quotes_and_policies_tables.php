<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * BLOQUE 4: Cotizaciones, Pólizas, Coberturas Contratadas y Movimientos Contractuales.
     */
    public function up(): void
    {
        // 1. Cotizaciones Comerciales Elegidas / Guardadas
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('organization_id')->constrained('organizations')->cascadeOnDelete();
            $table->foreignId('office_id')->nullable()->constrained('offices')->nullOnDelete();
            $table->foreignId('party_id')->constrained('parties')->cascadeOnDelete(); // Cliente interesado / tomador potencial
            $table->foreignId('insurer_id')->constrained('insurers')->cascadeOnDelete();
            $table->foreignId('insurance_branch_id')->constrained('insurance_branches')->cascadeOnDelete();
            $table->foreignId('insurance_product_id')->constrained('insurance_products')->cascadeOnDelete();
            $table->foreignId('pas_registration_id')->nullable()->constrained('pas_registrations')->nullOnDelete();
            $table->foreignId('insured_risk_id')->nullable()->constrained('insured_risks')->nullOnDelete();
            $table->decimal('sum_insured', 16, 2)->default(0.00); // Suma asegurada total
            $table->decimal('premium_net', 16, 2)->default(0.00); // Prima pura
            $table->decimal('taxes_amount', 16, 2)->default(0.00); // Impuestos, tasas y sellados
            $table->decimal('total_amount', 16, 2)->default(0.00); // Premio final cotizado
            $table->unsignedSmallInteger('installments_count')->default(1); // Cantidad de cuotas previstas
            $table->date('valid_until')->nullable(); // Vigencia de la oferta
            $table->json('quote_snapshot')->nullable(); // Snapshot con datos crudos devueltos por la aseguradora
            $table->string('status', 30)->default('borrador')->index(); // borrador, presentada, aceptada, rechazada, convertida_en_poliza, vencida
            $table->foreignId('created_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        // 2. Historial de Eventos de la Cotización (Seguimiento comercial hasta emisión)
        Schema::create('quote_events', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('quote_id')->constrained('quotes')->cascadeOnDelete();
            $table->string('event_type', 50)->index(); // creacion, envio_cliente, visto, aceptada, inspeccion_solicitada, documentacion_adjunta, enviada_a_emision, rechazada
            $table->string('previous_status', 30)->nullable();
            $table->string('new_status', 30)->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('performed_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->json('payload')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // 3. Pólizas Contratadas (Contrato oficial de seguro)
        Schema::create('policies', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('organization_id')->constrained('organizations')->cascadeOnDelete();
            $table->foreignId('office_id')->constrained('offices')->cascadeOnDelete(); // Oficina de origen de la venta
            $table->foreignId('insurer_id')->constrained('insurers')->cascadeOnDelete();
            $table->foreignId('insurance_product_id')->constrained('insurance_products')->cascadeOnDelete();
            $table->foreignId('pas_registration_id')->nullable()->constrained('pas_registrations')->nullOnDelete(); // Matrícula de intermediación
            $table->foreignId('insurer_agreement_id')->nullable()->constrained('insurer_agreements')->nullOnDelete(); // Convenio comercial aplicado
            $table->foreignId('quote_id')->nullable()->constrained('quotes')->nullOnDelete(); // Cotización previa que originó esta póliza (si aplica)
            $table->string('policy_number', 50)->index(); // Número de póliza oficial otorgado por la aseguradora
            $table->string('endorsement_number', 20)->default('0'); // Número de endoso o certificado
            $table->date('start_date'); // Inicio de vigencia
            $table->date('end_date'); // Fin de vigencia
            $table->date('issue_date')->nullable(); // Fecha de emisión oficial
            $table->string('billing_periodicity', 30)->default('mensual'); // mensual, bimestral, trimestral, cuatrimestral, semestral, anual
            $table->string('payment_method_type', 50)->default('efectivo_sucursal'); // efectivo_sucursal, recaudador_calle, debito_cbu, tarjeta, transferencia
            $table->string('status', 30)->default('vigente')->index(); // vigente, suspendida, anulada, vencida, cancelada
            $table->decimal('total_sum_insured', 16, 2)->default(0.00); // Suma asegurada total
            $table->decimal('net_premium', 16, 2)->default(0.00); // Prima pura / técnica (base de comisiones)
            $table->decimal('taxes_amount', 16, 2)->default(0.00); // Impuestos, tasas de SSN y sellados
            $table->decimal('total_premium', 16, 2)->default(0.00); // Premio final total (lo que paga el cliente)
            $table->foreignId('created_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['insurer_id', 'policy_number']);
        });

        // 4. Intervinientes en la Póliza (Tomador, Asegurado, Beneficiario, Pagador)
        Schema::create('policy_parties', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('policy_id')->constrained('policies')->cascadeOnDelete();
            $table->foreignId('party_id')->constrained('parties')->cascadeOnDelete();
            $table->string('role', 50)->default('tomador'); // tomador, asegurado, beneficiario, titular_pago
            $table->decimal('percentage', 5, 2)->default(100.00); // Porcentaje de titularidad o beneficio
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['policy_id', 'party_id', 'role']);
        });

        // 5. Riesgos Cubiertos por la Póliza (Puede amparar uno o varios riesgos)
        Schema::create('policy_risks', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('policy_id')->constrained('policies')->cascadeOnDelete();
            $table->foreignId('insured_risk_id')->constrained('insured_risks')->cascadeOnDelete();
            $table->decimal('sum_insured', 16, 2)->default(0.00);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['policy_id', 'insured_risk_id']);
        });

        // 6. Coberturas Efectivamente Contratadas (Límites y franquicias congeladas)
        Schema::create('policy_coverages', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('policy_risk_id')->constrained('policy_risks')->cascadeOnDelete();
            $table->foreignId('coverage_definition_id')->constrained('coverage_definitions')->cascadeOnDelete();
            $table->decimal('limit_amount', 16, 2)->nullable(); // Límite asegurado específico de la cobertura
            $table->decimal('deductible_amount', 16, 2)->nullable(); // Franquicia / Deducible
            $table->text('conditions_notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // 7. Movimientos Contractuales Inmutables (Emisiones, Endosos, Renovaciones, Anulaciones)
        Schema::create('policy_transactions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('policy_id')->constrained('policies')->cascadeOnDelete();
            $table->string('transaction_type', 50)->index(); // emision, endoso_aumento, endoso_baja, cambio_vehiculo, renovacion, anulacion
            $table->string('transaction_number', 50)->nullable();
            $table->date('effective_date'); // Fecha de entrada en vigor del endoso
            $table->text('description')->nullable();
            $table->decimal('premium_variation', 16, 2)->default(0.00); // Diferencia de prima generada
            $table->foreignId('registered_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('policy_transactions');
        Schema::dropIfExists('policy_coverages');
        Schema::dropIfExists('policy_risks');
        Schema::dropIfExists('policy_parties');
        Schema::dropIfExists('policies');
        Schema::dropIfExists('quote_events');
        Schema::dropIfExists('quotes');
    }
};
