<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'jurisdiction_code',
    ];

    public function setNameAttribute($valor)
    {
        $this->attributes['name'] = mb_strtolower($valor, 'UTF-8');
    }

    public function getNameAttribute($valor)
    {
        // Devuelve Todo Mayuscula
        // return mb_strtoupper($valor, 'UTF-8');
        // Devuelve solo la primera letra en mayuscula
        // return ucfirst(mb_strtolower($valor, 'UTF-8'));
        // Devuelve las primeras letras de cada palabra en mayuscula
        return ucwords(mb_strtolower($valor, 'UTF-8'));
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
