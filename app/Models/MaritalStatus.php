<?php

namespace App\Models;

use App\Models\Traits\HasCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaritalStatus extends Model
{
    use HasCode;
    use HasFactory;

    public $timestamps = false;

    const NOT_SPEC_TYPE = 'NO ESPECIFICADO';

    const NOT_SPEC_CODE = 'n/e';

    const SINGLE_TYPE = 'SOLTERO/A';

    const SINGLE_CODE = 'single';

    const MARRIED_TYPE = 'CASADO/A';

    const MARRIED_CODE = 'married';

    const DIVORCED_TYPE = 'DIVORCIADO/A';

    const DIVORCED_CODE = 'divorced';

    const WIDOWED_TYPE = 'VIUDO/A';

    const WIDOWED_CODE = 'widowed';

    const CONCUBINAGE_TYPE = 'EN CONCUBINATO';

    const CONCUBINAGE_CODE = 'concubinage';

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

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
