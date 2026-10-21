<?php

namespace App\Models;

use App\Traits\FindsByIdOrUuid;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CashRegister extends Model
{
    use FindsByIdOrUuid, HasFactory, HasUuid, SoftDeletes;

    protected $fillable = [
        'uuid',
        'office_id',
        'cash_register_type_id',
        'name',
        'code',
        'balance',
        'is_open',
        'is_active',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'balance' => 'decimal:2',
            'is_open' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Oficina donde está radicada la caja registradora.
     */
    public function office(): BelongsTo
    {
        return $this->belongsTo(Office::class);
    }

    /**
     * Clasificación o tipo de caja (Física, Virtual, Bancaria).
     */
    public function cashRegisterType(): BelongsTo
    {
        return $this->belongsTo(CashRegisterType::class);
    }
}
