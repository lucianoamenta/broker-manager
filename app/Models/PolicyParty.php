<?php

namespace App\Models;

use App\Traits\FindsByIdOrUuid;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PolicyParty extends Model
{
    use FindsByIdOrUuid, HasFactory, HasUuid, SoftDeletes;

    const ROLE_POLICYHOLDER = 'tomador';

    const ROLE_INSURED = 'asegurado';

    const ROLE_BENEFICIARY = 'beneficiario';

    const ROLE_PAYER = 'titular_pago';

    protected $fillable = [
        'uuid',
        'policy_id',
        'party_id',
        'role',
        'percentage',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'percentage' => 'decimal:2',
        ];
    }

    public function policy(): BelongsTo
    {
        return $this->belongsTo(Policy::class);
    }

    public function party(): BelongsTo
    {
        return $this->belongsTo(Party::class);
    }
}
