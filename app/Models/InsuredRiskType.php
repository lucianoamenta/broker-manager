<?php

namespace App\Models;

use App\Models\Traits\HasCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InsuredRiskType extends Model
{
    use HasCode, HasFactory;

    public $timestamps = false;

    const TYPE_VEHICLE = 'Vehículo Automotor';

    const CODE_VEHICLE = 'vehicle';

    const TYPE_PROPERTY = 'Inmueble / Propiedad';

    const CODE_PROPERTY = 'property';

    const TYPE_SURETY_BOND = 'Caución y Garantía';

    const CODE_SURETY_BOND = 'surety_bond';

    const TYPE_COMMERCIAL = 'Integral de Comercio e Industria';

    const CODE_COMMERCIAL = 'commercial';

    const TYPE_PERSON = 'Persona (Vida / AP)';

    const CODE_PERSON = 'person';

    protected $fillable = [
        'name',
        'code',
        'description',
    ];

    /**
     * Riesgos asegurables categorizados bajo este tipo.
     */
    public function insuredRisks(): HasMany
    {
        return $this->hasMany(InsuredRisk::class);
    }
}
