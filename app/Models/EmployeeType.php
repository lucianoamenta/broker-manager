<?php

namespace App\Models;

use App\Models\Traits\HasCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeType extends Model
{
    use HasCode, HasFactory;

    public $timestamps = false;

    const TYPE_GOD = 'God';

    const CODE_GOD = 'god';

    const TYPE_ADMIN = 'Administrador';

    const CODE_ADMIN = 'admin';

    const TYPE_OPERATOR = 'Operador';

    const CODE_OPERATOR = 'operator';

    const TYPE_BOT = 'Bot';

    const CODE_BOT = 'bot';

    const TYPE_CASHIER = 'Cajero';

    const CODE_CASHIER = 'cashier';

    const TYPE_COLLECTOR = 'Recaudador';

    const CODE_COLLECTOR = 'collector';

    const TYPE_ZONE_SUPERVISOR = 'Supervisor de Zona';

    const CODE_ZONE_SUPERVISOR = 'zone_supervisor';

    const TYPE_DEPARTMENT_HEAD = 'Jefe de Departamento';

    const CODE_DEPARTMENT_HEAD = 'department_head';

    const TYPE_PRODUCER = 'Productor Asesor';

    const CODE_PRODUCER = 'producer';

    protected $fillable = [
        'name',
        'code',
        'description',
    ];

    public function setNameAttribute($valor)
    {
        $this->attributes['name'] = mb_strtolower($valor, 'UTF-8');
    }

    public function getNameAttribute($valor)
    {
        return strtoupper($valor);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
