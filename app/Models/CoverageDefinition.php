<?php

namespace App\Models;

use App\Models\Traits\HasCode;
use App\Traits\FindsByIdOrUuid;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoverageDefinition extends Model
{
    use FindsByIdOrUuid, HasCode, HasFactory, HasUuid, SoftDeletes;

    protected $fillable = [
        'uuid',
        'insurance_branch_id',
        'name',
        'code',
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
     * Ramo asegurador al que aplica esta cobertura.
     */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(InsuranceBranch::class, 'insurance_branch_id');
    }
}
