<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes, HasUuid;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'names',
        'surnames',
        'cuit',
        'personal_phone',
        'personal_email',
        'address',
        'city_id',
        'gender_id',
        'marital_status_id',
        'employee_type_id',
        'user_id',
    ];

    public function setNamesAttribute($valor)
    {
        $this->attributes['names'] = mb_strtolower($valor, 'UTF-8');
    }

    public function setSurnamesAttribute($valor)
    {
        $this->attributes['surnames'] = mb_strtolower($valor, 'UTF-8');
    }

    public function getSurnamesAttribute($valor)
    {
        return ucwords($valor);
    }

    public function getNamesAttribute($valor)
    {
        return ucwords($valor);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    public function maritalStatus()
    {
        return $this->belongsTo(MaritalStatus::class);
    }

    public function employeeType()
    {
        return $this->belongsTo(EmployeeType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
