<?php

namespace App\Models;

use App\Models\Traits\HasCode;
use App\Traits\FindsByIdOrUuid;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Insurer extends Model
{
    use FindsByIdOrUuid, HasCode, HasFactory, HasUuid, SoftDeletes;

    protected $fillable = [
        'uuid',
        'name',
        'legal_name',
        'cuit',
        'code',
        'ssn_code',
        'email',
        'phone',
        'web_url',
        'url_logo',
        'is_active',
        'settings',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'settings' => 'array',
        ];
    }

    /**
     * Productos que comercializa la aseguradora.
     */
    public function insuranceProducts(): HasMany
    {
        return $this->hasMany(InsuranceProduct::class);
    }

    /**
     * Organizaciones que tienen habilitada esta aseguradora.
     */
    public function organizations(): BelongsToMany
    {
        return $this->belongsToMany(Organization::class, 'organization_insurers')
            ->withPivot(['is_active'])
            ->withTimestamps();
    }

    /**
     * Zonas que tienen habilitada esta aseguradora.
     */
    public function zones(): BelongsToMany
    {
        return $this->belongsToMany(Zone::class, 'zone_insurers')
            ->withPivot(['is_active'])
            ->withTimestamps();
    }

    /**
     * Convenios comerciales firmados con el broker o sus PAS.
     */
    public function agreements(): HasMany
    {
        return $this->hasMany(InsurerAgreement::class);
    }

    /**
     * Cotizaciones generadas con esta aseguradora.
     */
    public function quotes(): HasMany
    {
        return $this->hasMany(Quote::class);
    }

    /**
     * Pólizas emitidas por esta aseguradora.
     */
    public function policies(): HasMany
    {
        return $this->hasMany(Policy::class);
    }

    /**
     * Archivos y contratos adjuntos de la aseguradora.
     */
    public function files(): HasMany
    {
        return $this->hasMany(InsurerFile::class);
    }
}
