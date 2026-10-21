<?php

namespace App\Models;

use App\Traits\FindsByIdOrUuid;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CashMovement extends Model
{
    use FindsByIdOrUuid, HasFactory, HasUuid, SoftDeletes;

    const EFFECT_CREDIT = 'credit';

    const EFFECT_DEBIT = 'debit';

    const EFFECT_NEUTRAL = 'neutral';

    protected $fillable = [
        'uuid',
        'cash_register_id',
        'cash_session_id',
        'cash_movement_type_id',
        'effect',
        'amount',
        'previous_balance',
        'current_balance',
        'payment_id',
        'description',
        'performed_by_user_id',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'previous_balance' => 'decimal:2',
            'current_balance' => 'decimal:2',
        ];
    }

    public function cashRegister(): BelongsTo
    {
        return $this->belongsTo(CashRegister::class);
    }

    public function cashSession(): BelongsTo
    {
        return $this->belongsTo(CashSession::class);
    }

    public function movementType(): BelongsTo
    {
        return $this->belongsTo(CashMovementType::class, 'cash_movement_type_id');
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function performedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'performed_by_user_id');
    }

    public function files(): HasMany
    {
        return $this->hasMany(CashMovementFile::class);
    }
}
