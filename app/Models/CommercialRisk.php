<?php

namespace App\Models;

use App\Traits\FindsByIdOrUuid;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommercialRisk extends Model
{
    use FindsByIdOrUuid, HasFactory, HasUuid, SoftDeletes;

    protected $fillable = [
        'uuid',
        'insured_risk_id',
        'business_activity_id',
        'trade_name',
        'address',
        'city_id',
        'surface_m2',
        'declared_merchandise_value',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'surface_m2' => 'decimal:2',
            'declared_merchandise_value' => 'decimal:2',
        ];
    }

    public function insuredRisk(): BelongsTo
    {
        return $this->belongsTo(InsuredRisk::class);
    }

    public function businessActivity(): BelongsTo
    {
        return $this->belongsTo(BusinessActivity::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
