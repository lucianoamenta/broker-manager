<?php

namespace App\Models;

use App\Models\Traits\HasCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OccupationalStatus extends Model
{
    use HasCode;
    use HasFactory;

    public $timestamps = false;

    const NOT_SPEC_TYPE = 'NO ESPECIFICADO';

    const AM_TYPE = 'AMA DE CASA';

    const DS_TYPE = 'DESOCUPADO';

    const EE_TYPE = 'EMPLEADO DEL ESTADO';

    const EP_TYPE = 'EMPLEADO PRIVADO';

    const ES_TYPE = 'ESTUDIANTE';

    const JU_TYPE = 'JUBILADO';

    const PE_TYPE = 'PENSIONADO';

    const TA_TYPE = 'TRABAJADOR AUTÓNOMO';

    const TI_TYPE = 'TRABAJADOR INFORMAL';

    const VO_TYPE = 'VOLUNTARIO';

    protected $fillable = [
        'name',
        'code',
        'description',
    ];

    public function setNameAttribute($valor)
    {
        $this->attributes['name'] = mb_strtoupper($valor, 'UTF-8');
    }

    public function getNameAttribute($valor)
    {
        return mb_strtoupper($valor, 'UTF-8');
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }
}
