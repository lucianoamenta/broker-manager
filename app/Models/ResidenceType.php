<?php

namespace App\Models;

use App\Models\Traits\HasCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResidenceType extends Model
{
    use HasCode, HasFactory;

    public $timestamps = false;

    const HOME_TYPE = 'PARTICULAR';

    const WORK_TYPE = 'TRABAJO';

    const OFFICE_TYPE = 'OFICINA';

    protected $fillable = [
        'name',
        'code',
        'description',
    ];

    public function setNameAttribute($valor)
    {
        $this->attributes['name'] = strtoupper($valor);
    }

    public function residences()
    {
        return $this->hasMany(Residence::class);
    }
}
