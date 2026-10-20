<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // quién hizo la acción (puede ser null)
            $table->string('subject_type')->nullable();        // nombre del modelo afectado (ej: "Client", "Wallet")
            $table->string('subject_id')->nullable();          // ID del registro afectado (UUID o número)
            $table->string('event');                           // nombre de la acción: 'transfer_created', 'profile_updated', etc.
            $table->text('description')->nullable();    // descripcion humana de la acción.
            $table->json('changes')->nullable();               // qué cambió (opcional)
            $table->json('metadata')->nullable();              // IP, device, etc. (opcional)
            $table->timestamps();
        });

        // Índices para buscar rápido
        Schema::table('audits', function (Blueprint $table) {
            $table->index(['subject_type', 'subject_id']);
            $table->index('user_id');
            $table->index('event');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audits');
    }
};
