<?php

namespace App\Models;

use App\Traits\FindsByIdOrUuid;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PolicyCoverage extends Model
{
    use FindsByIdOrUuid, HasFactory, HasUuid, SoftDeletes;

    protected $fillable = [
        'uuid',
        'policy_risk_id',
        'coverage_definition_id',
        'limit_amount',
        'deductible_amount',
        'conditions_notes',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'limit_amount' => 'decimal:2',
            'deductible_amount' => 'decimal:2',
        ];
    }

    public function policyRisk(): BelongsTo
    {
        return $this->belongsTo(PolicyRisk::class);
    }

    public function definition(): BelongsTo
    {
        return $this->belongsTo(CoverageDefinition::class, 'coverage_definition_id');
    }
}
