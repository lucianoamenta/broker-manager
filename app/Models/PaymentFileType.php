<?php

namespace App\Models;

use App\Models\Traits\HasCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentFileType extends Model
{
    use HasCode, HasFactory;

    const NAME_BANK_TRANSFER_RECEIPT = 'Comprobante de Transferencia Bancaria';

    const CODE_BANK_TRANSFER_RECEIPT = 'transferencia_bancaria';

    const NAME_POSNET_SLIP = 'Cupón de Tarjeta / POSNET';

    const CODE_POSNET_SLIP = 'cupon_tarjeta';

    const NAME_CHECK_PHOTO = 'Foto de Cheque';

    const CODE_CHECK_PHOTO = 'foto_cheque';

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
        return $this->hasMany(PaymentFile::class);
    }
}
