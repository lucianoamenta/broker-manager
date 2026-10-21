<?php

namespace App\Models;

use App\Traits\FindsByIdOrUuid;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommissionSettlement extends Model
{
    use FindsByIdOrUuid, HasFactory, HasUuid, SoftDeletes;

    const RECIPIENT_PAS = 'pas';

    const RECIPIENT_OFFICE = 'office';

    const STATUS_DRAFT = 'borrador';

    const STATUS_APPROVED = 'aprobada';

    const STATUS_PAID = 'pagada';

    protected $fillable = [
        'uuid',
        'organization_id',
        'recipient_type',
        'recipient_id',
        'period_start',
        'period_end',
        'total_commission',
        'retentions_amount',
        'net_payable',
        'status',
        'approved_by_user_id',
        'paid_at',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'period_start' => 'date',
            'period_end' => 'date',
            'total_commission' => 'decimal:2',
            'retentions_amount' => 'decimal:2',
            'net_payable' => 'decimal:2',
            'paid_at' => 'datetime',
        ];
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function approvedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by_user_id');
    }

    /**
     * Entidad beneficiaria de la liquidación (PAS u Oficina).
     */
    public function recipient()
    {
        return $this->recipient_type === self::RECIPIENT_PAS
            ? $this->belongsTo(PasRegistration::class, 'recipient_id')
            : $this->belongsTo(Office::class, 'recipient_id');
    }
}
