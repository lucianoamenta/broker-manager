<?php

namespace App\Models;

use App\Traits\FindsByIdOrUuid;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PolicyTransaction extends Model
{
    use FindsByIdOrUuid, HasFactory, HasUuid, SoftDeletes;

    const TYPE_ISSUE = 'emision';

    const TYPE_ENDORSEMENT_INCREASE = 'endoso_aumento';

    const TYPE_ENDORSEMENT_DECREASE = 'endoso_baja';

    const TYPE_CHANGE_VEHICLE = 'cambio_vehiculo';

    const TYPE_RENEWAL = 'renovacion';

    const TYPE_CANCELLATION = 'anulacion';

    protected $fillable = [
        'uuid',
        'policy_id',
        'transaction_type',
        'transaction_number',
        'effective_date',
        'description',
        'premium_variation',
        'registered_by_user_id',
        'metadata',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'effective_date' => 'date',
            'premium_variation' => 'decimal:2',
            'metadata' => 'array',
        ];
    }

    public function policy(): BelongsTo
    {
        return $this->belongsTo(Policy::class);
    }

    public function registeredByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'registered_by_user_id');
    }
}
