<?php

namespace App\Models;

use App\Models\Traits\HasCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VoucherType extends Model
{
    use HasCode, HasFactory;

    public $timestamps = false;

    const NAME_OFFICIAL_RECEIPT = 'Recibo Oficial de Cobranza';

    const CODE_OFFICIAL_RECEIPT = 'recibo_oficial';

    const NAME_PAYMENT_PROOF = 'Constancia de Pago';

    const CODE_PAYMENT_PROOF = 'constancia_pago';

    const NAME_PROVISIONAL_RECEIPT = 'Recibo Provisorio';

    const CODE_PROVISIONAL_RECEIPT = 'recibo_provisorio';

    protected $fillable = [
        'name',
        'code',
        'description',
    ];

    public function vouchers(): HasMany
    {
        return $this->hasMany(Voucher::class);
    }
}
