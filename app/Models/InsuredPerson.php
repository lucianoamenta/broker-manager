<?php

namespace App\Models;

use App\Traits\FindsByIdOrUuid;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class InsuredPerson extends Model
{
    use FindsByIdOrUuid, HasFactory, HasUuid, SoftDeletes;

    protected $table = 'insured_people';

    protected $fillable = [
        'uuid',
        'insured_risk_id',
        'party_id',
        'occupation',
        'is_sports_practitioner',
        'has_preexisting_conditions',
        'notes',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_sports_practitioner' => 'boolean',
            'has_preexisting_conditions' => 'boolean',
        ];
    }

    public function insuredRisk(): BelongsTo
    {
        return $this->belongsTo(InsuredRisk::class);
    }

    public function party(): BelongsTo
    {
        return $this->belongsTo(Party::class);
    }
}
