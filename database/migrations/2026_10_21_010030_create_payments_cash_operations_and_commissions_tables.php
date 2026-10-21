<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * BLOQUE 5: Pagos, Recibos (Vouchers), Sesiones de Caja, Movimientos Contables con Efecto,
     * Rendiciones a Tesorería, Reglas de Comisión y Liquidaciones.
     */
    public function up(): void
    {
        // 1. Tipos de Comprobante / Recibo (Catálogo con HasCode: Recibo Oficial, Comprobante de Cobro, Constancia)
        Schema::create('voucher_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('code', 50)->unique();
            $table->text('description')->nullable();
        });

        // 2. Tipos de Movimiento de Caja (Apertura, Cierre, Cobro Póliza, Retiro Tesorería, Pago Servicios, etc.)
        Schema::create('cash_movement_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('code', 50)->unique();
            $table->string('default_effect', 20)->default('neutral'); // credit, debit, neutral
            $table->text('description')->nullable();
        });

        // 3. Sesiones y Turnos de Caja Registradora (Aperturas y Cierres)
        Schema::create('cash_sessions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('cash_register_id')->constrained('cash_registers')->cascadeOnDelete();
            $table->foreignId('cashier_id')->constrained('cashiers')->cascadeOnDelete();
            $table->foreignId('opened_by_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('closed_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('opened_at')->index();
            $table->timestamp('closed_at')->nullable();
            $table->string('status', 30)->default('abierta')->index(); // abierta, cerrada
            $table->text('closing_notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // 4. Pagos Recibidos (Asociados directamente a la póliza y su cuota)
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('organization_id')->constrained('organizations')->cascadeOnDelete();
            $table->foreignId('policy_id')->nullable()->constrained('policies')->nullOnDelete(); // Póliza que se está cobrando
            $table->foreignId('party_id')->constrained('parties')->cascadeOnDelete(); // Pagador / Cliente
            $table->unsignedSmallInteger('installment_number')->nullable(); // Número de cuota abonada (1, 2, 3...)
            $table->string('period_covered', 100)->nullable(); // Ej: "Octubre 2026" o "Cuota 2/6"
            $table->decimal('amount', 16, 2); // Monto efectivamente pagado
            $table->string('payment_method', 50)->default('efectivo'); // efectivo, transferencia, tarjeta, qr, debito
            $table->string('channel', 50)->default('sucursal_caja'); // sucursal_caja, recaudador_calle, plataforma_online
            $table->timestamp('received_at')->index();
            $table->string('external_transaction_id', 100)->nullable(); // Código de transacción bancaria / cupón
            $table->text('notes')->nullable();
            $table->string('status', 30)->default('confirmado')->index(); // confirmado, pendiente, anulado, rechazado
            $table->foreignId('received_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        // 5. Comprobantes / Recibos Emitidos (Imprimibles y adjuntos al pago)
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('voucher_type_id')->constrained('voucher_types')->restrictOnDelete();
            $table->foreignId('payment_id')->nullable()->constrained('payments')->nullOnDelete();
            $table->foreignId('policy_id')->nullable()->constrained('policies')->nullOnDelete();
            $table->foreignId('party_id')->constrained('parties')->cascadeOnDelete();
            $table->foreignId('office_id')->nullable()->constrained('offices')->nullOnDelete();
            $table->string('voucher_number', 50)->unique(); // Ej: "REC-0001-0004523"
            $table->decimal('amount', 16, 2);
            $table->timestamp('issue_date')->index();
            $table->text('pdf_url')->nullable(); // Enlace a S3 del comprobante generado
            $table->foreignId('issued_by_user_id')->constrained('users')->cascadeOnDelete();
            $table->string('status', 30)->default('emitido')->index(); // emitido, anulado
            $table->timestamps();
            $table->softDeletes();
        });

        // 6. Movimientos Contables en Caja (Libro diario de ingresos, egresos y arqueos)
        Schema::create('cash_movements', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('cash_register_id')->constrained('cash_registers')->cascadeOnDelete();
            $table->foreignId('cash_session_id')->nullable()->constrained('cash_sessions')->nullOnDelete();
            $table->foreignId('cash_movement_type_id')->constrained('cash_movement_types')->restrictOnDelete();
            $table->string('effect', 20)->default('neutral'); // credit (+), debit (-), neutral (0)
            $table->decimal('amount', 16, 2)->default(0.00); // Monto del movimiento
            $table->decimal('previous_balance', 16, 2); // Saldo en caja antes del movimiento
            $table->decimal('current_balance', 16, 2); // Saldo en caja resultante tras el movimiento
            $table->foreignId('payment_id')->nullable()->constrained('payments')->nullOnDelete();
            $table->string('description', 250);
            $table->foreignId('performed_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        // 6. Lotes de Cobranza de Recaudadores en Calle
        Schema::create('collection_batches', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('collector_id')->constrained('collectors')->cascadeOnDelete();
            $table->foreignId('organization_id')->constrained('organizations')->cascadeOnDelete();
            $table->timestamp('started_at')->index();
            $table->timestamp('closed_at')->nullable();
            $table->decimal('total_collected_amount', 16, 2)->default(0.00); // Total recaudado en el recorrido
            $table->string('status', 30)->default('en_curso')->index(); // en_curso, cerrado, rendido_a_tesoreria, auditado
            $table->timestamps();
            $table->softDeletes();
        });

        // 7. Rendición del Dinero del Recaudador hacia el Departamento de Tesorería
        Schema::create('collection_settlements', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('collection_batch_id')->constrained('collection_batches')->cascadeOnDelete();
            $table->foreignId('department_id')->constrained('departments')->cascadeOnDelete(); // Departamento que recibe los fondos (ej. Tesorería)
            $table->foreignId('delivered_by_user_id')->constrained('users')->cascadeOnDelete(); // Usuario recaudador que entrega el sobre/dinero
            $table->foreignId('received_by_user_id')->constrained('users')->cascadeOnDelete(); // Usuario tesorero/contador que cuenta y recibe
            $table->decimal('delivered_amount', 16, 2); // Monto que el recaudador declara entregar
            $table->decimal('received_amount', 16, 2); // Monto real contado y aceptado por tesorería
            $table->decimal('difference', 16, 2)->default(0.00); // Diferencia si hubo faltante/sobrante
            $table->timestamp('settled_at')->index(); // Fecha y hora de recepción y conformidad
            $table->string('status', 30)->default('recibido_completo')->index(); // recibido_completo, recibido_con_diferencia, observado
            $table->text('settlement_notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // 8. Reglas de Comisión Configurables y Versionadas
        Schema::create('commission_rules', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('organization_id')->constrained('organizations')->cascadeOnDelete();
            $table->foreignId('insurer_id')->constrained('insurers')->cascadeOnDelete();
            $table->foreignId('insurance_branch_id')->nullable()->constrained('insurance_branches')->nullOnDelete();
            $table->foreignId('insurance_product_id')->nullable()->constrained('insurance_products')->nullOnDelete();
            $table->decimal('company_commission_rate', 5, 2)->default(0.00); // % que reconoce la aseguradora sobre la prima pura
            $table->decimal('pas_commission_rate', 5, 2)->default(0.00); // % que va para el Productor Asesor (ej. 25%)
            $table->decimal('office_commission_rate', 5, 2)->default(0.00); // % que queda para la oficina local (ej. 3%)
            $table->decimal('broker_retention_rate', 5, 2)->default(0.00); // % que retiene el broker / matriz por mantenimiento (ej. 2%)
            $table->date('valid_from');
            $table->date('valid_until')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
            $table->softDeletes();
        });

        // 9. Fotografía Inmutable de Distribución Económica de cada Pago Registrado
        Schema::create('commission_distributions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('payment_id')->constrained('payments')->cascadeOnDelete();
            $table->foreignId('policy_id')->constrained('policies')->cascadeOnDelete();
            $table->foreignId('commission_rule_id')->nullable()->constrained('commission_rules')->nullOnDelete();
            $table->foreignId('pas_registration_id')->nullable()->constrained('pas_registrations')->nullOnDelete();
            $table->foreignId('office_id')->nullable()->constrained('offices')->nullOnDelete();
            $table->decimal('total_collected', 16, 2); // Base total cobrada en este pago (ej. $100.000)
            $table->decimal('insurer_amount', 16, 2); // Parte de la Aseguradora (ej. $70.000)
            $table->decimal('pas_amount', 16, 2); // Comisión líquida del PAS (ej. $25.000)
            $table->decimal('office_amount', 16, 2); // Participación de la oficina (ej. $3.000)
            $table->decimal('broker_amount', 16, 2); // Retención / Ganancia del Broker (ej. $2.000)
            $table->string('status', 30)->default('calculada')->index(); // calculada, retenida, liquidada, pagada
            $table->timestamp('calculated_at')->index();
            $table->timestamps();
            $table->softDeletes();
        });

        // 10. Liquidaciones Periódicas a Productores (PAS) y Oficinas
        Schema::create('commission_settlements', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('organization_id')->constrained('organizations')->cascadeOnDelete();
            $table->string('recipient_type', 30)->index(); // pas, office
            $table->unsignedBigInteger('recipient_id')->index(); // ID del PAS o de la Oficina
            $table->date('period_start');
            $table->date('period_end');
            $table->decimal('total_commission', 16, 2); // Total bruto acumulado en el período
            $table->decimal('retentions_amount', 16, 2)->default(0.00); // Retenciones impositivas / adelantos
            $table->decimal('net_payable', 16, 2); // Neto a transferir
            $table->string('status', 30)->default('borrador')->index(); // borrador, aprobada, pagada
            $table->foreignId('approved_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commission_settlements');
        Schema::dropIfExists('commission_distributions');
        Schema::dropIfExists('commission_rules');
        Schema::dropIfExists('collection_settlements');
        Schema::dropIfExists('collection_batches');
        Schema::dropIfExists('cash_movements');
        Schema::dropIfExists('cash_movement_types');
        Schema::dropIfExists('vouchers');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('cash_sessions');
        Schema::dropIfExists('voucher_types');
    }
};
