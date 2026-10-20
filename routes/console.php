<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| 🖥️ Console Routes & Scheduler
|--------------------------------------------------------------------------
|
| //!INFO Aquí centralizamos la lógica de comandos y tareas programadas.
| 
| //!NOTE CONFIGURACIÓN EN FORGE (Deploy):
| 1. SCHEDULER: Configurar una ÚNICA tarea que corra cada minuto:
|    * Command: php /home/forge/tu-sitio.com/artisan schedule:run
| 
| 2. QUEUE WORKERS: Crear worker en la pestaña Queue:
|    * Worker 1: Connection: redis | Queue: default
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

//!NOTE Backup del Sistema (Spatie)
// Asegúrate de configurar S3 en el .env para los backups
Schedule::command('backup:run')->daily()->at('03:00')->onOneServer();
Schedule::command('backup:clean')->daily()->at('01:00')->onOneServer();

//!NOTE Mantenimiento del Sistema
// Limpia tokens expirados, sesiones huérfanas y registros de dispositivos viejos
Schedule::command('system:cleanup-sessions')->weekly()->at('04:00')->onOneServer();
