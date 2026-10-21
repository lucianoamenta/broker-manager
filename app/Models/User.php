<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasRoles, HasUuid;
    use Notifiable;
    use SoftDeletes;

    const ROL_GOD = 'god';

    const ROL_ADMIN = 'admin';

    const ROL_CLIENTE = 'client';

    const ROL_EMPLEADO = 'employee';

    const ROL_BOT = 'bot';

    const ROL_ZONE_MANAGER = 'zone_manager';

    const ROL_DEPARTMENT_HEAD = 'department_head';

    const ROL_CASHIER = 'cashier';

    const ROL_COLLECTOR = 'collector';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'uuid',
        'username',
        'is_verified',
        'is_allowed',
        'verification_token',
        'profile_picture',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'verification_token',
    ];

    public function setEmailAttribute($valor)
    {
        $this->attributes['email'] = strtolower($valor);
    }

    public function esVerificado()
    {
        return $this->is_verified == true;
    }

    public function estaHabilitado()
    {
        return $this->is_allowed == true;
    }

    public static function generarVerificationToken()
    {
        return Str::random_int(6);
    }

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Relación: todas las auditorías realizadas por este usuario.
     */
    public function audits()
    {
        return $this->hasMany(Audit::class);
    }

    /**
     * Representación corporativa de la organización vinculada a este usuario.
     */
    public function organizationRepresentative(): HasOne
    {
        return $this->hasOne(OrganizationRepresentative::class);
    }

    /**
     * Representación o supervisión de zona vinculada a este usuario.
     */
    public function zoneRepresentative(): HasOne
    {
        return $this->hasOne(ZoneRepresentative::class);
    }

    /**
     * Representación o encargado de oficina vinculado a este usuario.
     */
    public function officeRepresentative(): HasOne
    {
        return $this->hasOne(OfficeRepresentative::class);
    }

    /**
     * Representación o jefatura de departamento vinculada a este usuario.
     */
    public function departmentRepresentative(): HasOne
    {
        return $this->hasOne(DepartmentRepresentative::class);
    }

    /**
     * Asignación de cajero vinculada a este usuario.
     */
    public function cashier(): HasOne
    {
        return $this->hasOne(Cashier::class);
    }

    /**
     * Registro de recaudador vinculado a este usuario.
     */
    public function collector(): HasOne
    {
        return $this->hasOne(Collector::class);
    }
}
