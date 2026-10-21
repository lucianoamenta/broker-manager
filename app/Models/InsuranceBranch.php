<?php

namespace App\Models;

use App\Models\Traits\HasCode;
use App\Traits\FindsByIdOrUuid;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class InsuranceBranch extends Model
{
    use FindsByIdOrUuid, HasCode, HasFactory, HasUuid, SoftDeletes;

    const BRANCH_AUTO = 'automotores';

    const BRANCH_HOME = 'hogar';

    const BRANCH_LIFE = 'vida';

    const BRANCH_ACCIDENTS = 'accidentes_personales';

    const BRANCH_SURETY = 'caucion';

    const BRANCH_COMMERCIAL = 'comercio_integral';

    protected $fillable = [
        'uuid',
        'name',
        'code',
        'description',
        'icon',
        'is_active',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * Productos que pertenecen a este ramo.
     */
    public function insuranceProducts(): HasMany
    {
        return $this->hasMany(InsuranceProduct::class);
    }

    /**
     * Coberturas base definidas para este ramo.
     */
    public function coverageDefinitions(): HasMany
    {
        return $this->hasMany(CoverageDefinition::class);
    }

    /**
     * Cotizaciones realizadas en este ramo.
     */
    public function quotes(): HasMany
    {
        return $this->hasMany(Quote::class);
    }
}
