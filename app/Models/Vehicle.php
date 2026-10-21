<?php

namespace App\Models;

use App\Traits\FindsByIdOrUuid;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use FindsByIdOrUuid, HasFactory, HasUuid, SoftDeletes;

    const USAGE_PARTICULAR = 'particular';

    const USAGE_COMMERCIAL = 'comercial';

    const USAGE_TAXI = 'taxi';

    const USAGE_REMIS = 'remis';

    const USAGE_CARGO = 'carga';

    protected $fillable = [
        'uuid',
        'insured_risk_id',
        'license_plate',
        'make',
        'model',
        'version',
        'year',
        'engine_number',
        'chassis_number',
        'usage_type',
        'gnc',
        'is_zero_km',
        'color',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'year' => 'integer',
            'gnc' => 'boolean',
            'is_zero_km' => 'boolean',
        ];
    }

    public function insuredRisk(): BelongsTo
    {
        return $this->belongsTo(InsuredRisk::class);
    }
}
