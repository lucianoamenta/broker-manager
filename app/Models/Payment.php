<?php

namespace App\Models;

use App\Traits\FindsByIdOrUuid;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use FindsByIdOrUuid, HasFactory, HasUuid, SoftDeletes;

    const METHOD_CASH = 'efectivo';

    const METHOD_TRANSFER = 'transferencia';

    const METHOD_CARD = 'tarjeta';

    const METHOD_QR = 'qr';

    const METHOD_DIRECT_DEBIT = 'debito';

    const CHANNEL_OFFICE = 'sucursal_caja';

    const CHANNEL_COLLECTOR = 'recaudador_calle';

    const CHANNEL_ONLINE = 'plataforma_online';

    const STATUS_CONFIRMED = 'confirmado';

    const STATUS_PENDING = 'pendiente';

    const STATUS_CANCELLED = 'anulado';

    const STATUS_REJECTED = 'rechazado';

    protected $fillable = [
        'uuid',
        'organization_id',
        'policy_id',
        'party_id',
        'installment_number',
        'period_covered',
        'amount',
        'payment_method',
        'channel',
        'received_at',
        'external_transaction_id',
        'notes',
        'status',
        'received_by_user_id',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'installment_number' => 'integer',
            'received_at' => 'datetime',
        ];
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function policy(): BelongsTo
    {
        return $this->belongsTo(Policy::class);
    }

    public function party(): BelongsTo
    {
        return $this->belongsTo(Party::class);
    }

    public function receivedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'received_by_user_id');
    }

    public function voucher(): HasOne
    {
        return $this->hasOne(Voucher::class);
    }

    public function cashMovement(): HasOne
    {
        return $this->hasOne(CashMovement::class);
    }

    public function commissionDistribution(): HasOne
    {
        return $this->hasOne(CommissionDistribution::class);
    }

    public function files(): HasMany
    {
        return $this->hasMany(PaymentFile::class);
    }
}
