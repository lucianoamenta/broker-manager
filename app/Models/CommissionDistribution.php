<?php

namespace App\Models;

use App\Traits\FindsByIdOrUuid;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommissionDistribution extends Model
{
    use FindsByIdOrUuid, HasFactory, HasUuid, SoftDeletes;

    const STATUS_CALCULATED = 'calculada';

    const STATUS_WITHHELD = 'retenida';

    const STATUS_SETTLED = 'liquidada';

    const STATUS_PAID = 'pagada';

    protected $fillable = [
        'uuid',
        'payment_id',
        'policy_id',
        'commission_rule_id',
        'pas_registration_id',
        'office_id',
        'total_collected',
        'insurer_amount',
        'pas_amount',
        'office_amount',
        'broker_amount',
        'status',
        'calculated_at',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'total_collected' => 'decimal:2',
            'insurer_amount' => 'decimal:2',
            'pas_amount' => 'decimal:2',
            'office_amount' => 'decimal:2',
            'broker_amount' => 'decimal:2',
            'calculated_at' => 'datetime',
        ];
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function policy(): BelongsTo
    {
        return $this->belongsTo(Policy::class);
    }

    public function rule(): BelongsTo
    {
        return $this->belongsTo(CommissionRule::class, 'commission_rule_id');
    }

    public function pasRegistration(): BelongsTo
    {
        return $this->belongsTo(PasRegistration::class);
    }

    public function office(): BelongsTo
    {
        return $this->belongsTo(Office::class);
    }
}
