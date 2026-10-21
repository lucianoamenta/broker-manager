<?php

namespace App\Models;

use App\Traits\FindsByIdOrUuid;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use FindsByIdOrUuid, HasFactory, HasUuid, SoftDeletes;

    const TYPE_HOUSE = 'house';

    const TYPE_APARTMENT = 'apartment';

    const TYPE_COUNTRY = 'country';

    const TYPE_WAREHOUSE = 'warehouse';

    protected $fillable = [
        'uuid',
        'insured_risk_id',
        'property_type',
        'address',
        'city_id',
        'postal_code',
        'covered_surface_m2',
        'construction_type',
        'security_measures',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'covered_surface_m2' => 'decimal:2',
        ];
    }

    public function insuredRisk(): BelongsTo
    {
        return $this->belongsTo(InsuredRisk::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
