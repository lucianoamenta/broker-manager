<?php

namespace App\Models;

use App\Models\Traits\HasCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FiscalCondition extends Model
{
    use HasCode;
    use HasFactory;

    public $timestamps = false;

    const NOT_SPEC_TYPE = 'NO ESPECIFICADO';

    const NOT_SPEC_CODE = 'n/e';

    const CF_TYPE = 'CONSUMIDOR FINAL';

    const CF_CODE = 'cf';

    const RN_TYPE = 'RESPONSABLE INSCRIPTO';

    const RN_CODE = 'rn';

    const RNI_TYPE = 'RESPONSABLE NO INSCRIPTO';

    const RNI_CODE = 'rni';

    const EX_TYPE = 'EXENTOS';

    const EX_CODE = 'ex';

    const RM_TYPE = 'MONOTRIBUTISTA';

    const RM_CODE = 'rm';

    const NC_TYPE = 'NO CATEGORIZADO';

    const NC_CODE = 'nc';

    const NR_TYPE = 'NO RESPONSABLE';

    const NR_CODE = 'nr';

    protected $fillable = [
        'name',
        'code',
        'description',
    ];

    public function setNameAttribute($valor)
    {
        $this->attributes['name'] = strtoupper($valor);
    }
}
