<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
}
