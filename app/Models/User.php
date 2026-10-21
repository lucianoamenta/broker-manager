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

    // --- Roles Principales / Internos (Personal y Staff de Plataforma) ---
    const ROL_GOD = 'god';

    const ROL_ADMIN = 'admin';

    const ROL_EMPLEADO = 'employee';

    const ROL_EMPLOYEE = self::ROL_EMPLEADO;

    const ROL_BOT = 'bot';

    const ROL_MARKETING = 'marketing';

    const ROL_TESORERO = 'treasurer';

    const ROL_TREASURER = self::ROL_TESORERO;

    const ROL_AUDITOR = 'auditor';

    const ROL_ABOGADO = 'lawyer';

    const ROL_LAWYER = self::ROL_ABOGADO;

    // --- Roles Organizacionales y Territoriales (Representantes / Encargados) ---
    const ROL_ADMIN_ORGANIZATION = 'admin_organization';

    const ROL_ADMIN_ZONE = 'admin_zone';

    const ROL_ADMIN_DEPARTMENT = 'admin_department';

    const ROL_ADMIN_OFFICE = 'admin_office';

    const ROL_TESORERO_DEPARTMENT = 'treasurer_department';

    const ROL_TREASURER_DEPARTMENT = self::ROL_TESORERO_DEPARTMENT;

    const ROL_ABOGADO_DEPARTMENT = 'lawyer_department';

    const ROL_LAWYER_DEPARTMENT = self::ROL_ABOGADO_DEPARTMENT;

    // --- Roles Operativos de Sucursal, Caja y Cobranza ---
    const ROL_CASHIER = 'cashier';

    const ROL_COLLECTOR = 'collector';

    // --- Rol de Clientes Finales / Asegurados (Parties) ---
    const ROL_CLIENTE = 'client';

    const ROL_CLIENT = self::ROL_CLIENTE;

    // --- Aliases de compatibilidad con versiones previas ---
    /** @deprecated Usar ROL_ADMIN_ZONE */
    const ROL_ZONE_MANAGER = self::ROL_ADMIN_ZONE;

    /** @deprecated Usar ROL_ADMIN_DEPARTMENT */
    const ROL_DEPARTMENT_HEAD = self::ROL_ADMIN_DEPARTMENT;

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

    /**
     * Perfil de cliente / asegurado (Party) vinculado a este usuario.
     */
    public function party(): HasOne
    {
        return $this->hasOne(Party::class);
    }

    /**
     * Lista completa y normalizada de todos los roles disponibles en el sistema.
     *
     * @return array<int, string>
     */
    public static function getAvailableRoles(): array
    {
        return [
            self::ROL_GOD,
            self::ROL_ADMIN,
            self::ROL_EMPLEADO,
            self::ROL_BOT,
            self::ROL_MARKETING,
            self::ROL_TESORERO,
            self::ROL_AUDITOR,
            self::ROL_ABOGADO,
            self::ROL_ADMIN_ORGANIZATION,
            self::ROL_ADMIN_ZONE,
            self::ROL_ADMIN_DEPARTMENT,
            self::ROL_ADMIN_OFFICE,
            self::ROL_TESORERO_DEPARTMENT,
            self::ROL_ABOGADO_DEPARTMENT,
            self::ROL_CASHIER,
            self::ROL_COLLECTOR,
            self::ROL_CLIENTE,
        ];
    }
}
