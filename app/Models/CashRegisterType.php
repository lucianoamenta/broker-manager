<?php

namespace App\Models;

use App\Models\Traits\HasCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CashRegisterType extends Model
{
    use HasCode, HasFactory;

    public $timestamps = false;

    const TYPE_PHYSICAL = 'Caja Física';

    const CODE_PHYSICAL = 'physical';

    const TYPE_VIRTUAL = 'Caja Virtual';

    const CODE_VIRTUAL = 'virtual';

    const TYPE_BANK = 'Cuenta Bancaria';

    const CODE_BANK = 'bank';

    protected $fillable = [
        'name',
        'code',
        'description',
    ];

    /**
     * Cajas registradoras correspondientes a este tipo.
     */
    public function cashRegisters(): HasMany
    {
        return $this->hasMany(CashRegister::class);
    }
}
