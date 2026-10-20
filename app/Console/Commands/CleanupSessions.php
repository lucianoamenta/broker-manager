<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Device;

class CleanupSessions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:cleanup-sessions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up expired Sanctum tokens, orphan web sessions, and old device records.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando limpieza del sistema...');

        // 1. Limpiar Tokens de Sanctum (Llamamos al comando nativo)
        $this->call('sanctum:prune-expired', ['--hours' => 24]);
        $this->info('✓ Tokens expirados de Sanctum eliminados.');

        // 2. Limpiar la tabla de sesiones de Laravel (opcional pero recomendado)
        // Laravel lo hace solo según el config/session.php (lottery), pero aquí lo forzamos.
        // Solo aplica si SESSION_DRIVER=database
        if (config('session.driver') === 'database') {
            $expiredAt = now()->subMinutes(config('session.lifetime'))->getTimestamp();
            DB::table('sessions')
                ->where('last_activity', '<', $expiredAt)
                ->delete();
            $this->info('✓ Sesiones web obsoletas eliminadas de la base de datos.');
        }

        // 3. Limpiar la tabla de DEVICES
        // Buscamos dispositivos activos que ya no tengan sesión real vinculada
        $devices = Device::all();
        $softDeletedCount = 0;

        foreach ($devices as $device) {
            if (!$device->isActive()) {
                $device->delete(); // Soft delete
                $softDeletedCount++;
            }
        }
        $this->info("✓ Se marcaron como inactivas {$softDeletedCount} sesiones de dispositivos.");

        // 4. Limpieza física (Hard Delete) de registros borrados hace más de 7 días
        $purgedCount = Device::onlyTrashed()
            ->where('deleted_at', '<', now()->subDays(7))
            ->forceDelete();
        
        if ($purgedCount > 0) {
            $this->info("✓ Se eliminaron permanentemente {$purgedCount} registros de dispositivos antiguos.");
        }

        $this->info('Limpieza completada exitosamente.');
        
        return 0;
    }
}
