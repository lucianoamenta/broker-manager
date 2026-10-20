<?php

namespace App\Models;

use App\Models\Traits\HasCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profession extends Model
{
    use HasCode;
    use HasFactory;

    public $timestamps = false;

    const NOT_SPEC_TYPE = 'NO ESPECIFICADO';

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
