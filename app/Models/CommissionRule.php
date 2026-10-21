<?php

namespace App\Models;

use App\Traits\FindsByIdOrUuid;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommissionRule extends Model
{
    use FindsByIdOrUuid, HasFactory, HasUuid, SoftDeletes;

    protected $fillable = [
        'uuid',
        'organization_id',
        'insurer_id',
        'insurance_branch_id',
        'insurance_product_id',
        'company_commission_rate',
        'pas_commission_rate',
        'office_commission_rate',
        'broker_retention_rate',
        'valid_from',
        'valid_until',
        'is_active',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'company_commission_rate' => 'decimal:2',
            'pas_commission_rate' => 'decimal:2',
            'office_commission_rate' => 'decimal:2',
            'broker_retention_rate' => 'decimal:2',
            'valid_from' => 'date',
            'valid_until' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function insurer(): BelongsTo
    {
        return $this->belongsTo(Insurer::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(InsuranceBranch::class, 'insurance_branch_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(InsuranceProduct::class, 'insurance_product_id');
    }

    public function distributions(): HasMany
    {
        return $this->hasMany(CommissionDistribution::class);
    }
}
