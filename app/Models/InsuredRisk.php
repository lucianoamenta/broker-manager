<?php

namespace App\Models;

use App\Traits\FindsByIdOrUuid;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class InsuredRisk extends Model
{
    use FindsByIdOrUuid, HasFactory, HasUuid, SoftDeletes;

    const RISK_VEHICLE = 'vehicle';

    const RISK_PROPERTY = 'property';

    const RISK_SURETY = 'surety_bond';

    const RISK_COMMERCIAL = 'commercial';

    const RISK_PERSON = 'person';

    protected $fillable = [
        'uuid',
        'party_id',
        'insured_risk_type_id',
        'identifier',
        'description',
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
     * Tipo de bien o riesgo asegurable tipado.
     */
    public function insuredRiskType(): BelongsTo
    {
        return $this->belongsTo(InsuredRiskType::class);
    }

    public function party(): BelongsTo
    {
        return $this->belongsTo(Party::class);
    }

    public function vehicle(): HasOne
    {
        return $this->hasOne(Vehicle::class);
    }

    public function property(): HasOne
    {
        return $this->hasOne(Property::class);
    }

    public function suretyBond(): HasOne
    {
        return $this->hasOne(SuretyBond::class);
    }

    public function commercialRisk(): HasOne
    {
        return $this->hasOne(CommercialRisk::class);
    }

    public function insuredPerson(): HasOne
    {
        return $this->hasOne(InsuredPerson::class);
    }
}
