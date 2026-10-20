<?php

namespace App\Models;

use App\Models\Traits\HasCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    use HasCode;
    use HasFactory;

    public $timestamps = false;

    const NOT_SPEC_TYPE = 'NO ESPECIFICADO';

    const NOT_SPEC_CODE = 'n/e';

    const MALE_TYPE = 'MASCULINO';

    const MALE_CODE = 'male';

    const FEMALE_TYPE = 'FEMENINO';

    const FEMALE_CODE = 'female';

    const NOT_BIN_TYPE = 'NO BINARIO';

    const NOT_BIN_CODE = 'not_bin';

    const NOT_GENDER_TYPE = 'NO TIENE GENERO';

    const NOT_GENDER_CODE = 'not_gender';

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
