<?php

namespace App\Models;

use App\Traits\FindsByIdOrUuid;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voucher extends Model
{
    use FindsByIdOrUuid, HasFactory, HasUuid, SoftDeletes;

    const STATUS_ISSUED = 'emitido';

    const STATUS_CANCELLED = 'anulado';

    protected $fillable = [
        'uuid',
        'voucher_type_id',
        'payment_id',
        'policy_id',
        'party_id',
        'office_id',
        'voucher_number',
        'amount',
        'issue_date',
        'pdf_url',
        'issued_by_user_id',
        'status',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'issue_date' => 'datetime',
        ];
    }

    public function voucherType(): BelongsTo
    {
        return $this->belongsTo(VoucherType::class);
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function policy(): BelongsTo
    {
        return $this->belongsTo(Policy::class);
    }

    public function party(): BelongsTo
    {
        return $this->belongsTo(Party::class);
    }

    public function office(): BelongsTo
    {
        return $this->belongsTo(Office::class);
    }

    public function issuedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'issued_by_user_id');
    }
}
