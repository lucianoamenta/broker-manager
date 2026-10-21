<?php

namespace App\Models;

use App\Traits\FindsByIdOrUuid;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PolicyRisk extends Model
{
    use FindsByIdOrUuid, HasFactory, HasUuid, SoftDeletes;

    protected $fillable = [
        'uuid',
        'policy_id',
        'insured_risk_id',
        'sum_insured',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'sum_insured' => 'decimal:2',
        ];
    }

    public function policy(): BelongsTo
    {
        return $this->belongsTo(Policy::class);
    }

    public function insuredRisk(): BelongsTo
    {
        return $this->belongsTo(InsuredRisk::class);
    }

    public function coverages(): HasMany
    {
        return $this->hasMany(PolicyCoverage::class);
    }
}
