<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'cities';

    protected $filable = [
        'name',
        'cp',
        'full_cp',
        'province_id',
    ];

    protected $hidden = ['province_id'];

    public function setNameAttribute($valor)
    {
        $this->attributes['name'] = mb_strtolower($valor, 'UTF-8');
    }

    public function getNameAttribute($valor)
    {
        return strtoupper($valor);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }
}
