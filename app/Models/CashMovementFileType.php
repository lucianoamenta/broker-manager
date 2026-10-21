<?php

namespace App\Models;

use App\Models\Traits\HasCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CashMovementFileType extends Model
{
    use HasCode, HasFactory;

    const NAME_EXPENSE_INVOICE = 'Factura / Ticket de Gasto';

    const CODE_EXPENSE_INVOICE = 'factura_gasto';

    const NAME_BANK_DEPOSIT_SLIP = 'Boleta de Depósito Bancario';

    const CODE_BANK_DEPOSIT_SLIP = 'deposito_bancario';

    const NAME_TREASURY_RECEIPT = 'Recibo de Retiro por Tesorería';

    const CODE_TREASURY_RECEIPT = 'recibo_retiro_tesoreria';

    protected $fillable = [
        'name',
        'code',
        'description',
        'max_size_mb',
        'accepted_formats',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'max_size_mb' => 'integer',
            'accepted_formats' => 'array',
        ];
    }

    public function files(): HasMany
    {
        return $this->hasMany(CashMovementFile::class);
    }
}
