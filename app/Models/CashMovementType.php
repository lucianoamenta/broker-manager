<?php

namespace App\Models;

use App\Models\Traits\HasCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CashMovementType extends Model
{
    use HasCode, HasFactory;

    public $timestamps = false;

    const EFFECT_CREDIT = 'credit';

    const EFFECT_DEBIT = 'debit';

    const EFFECT_NEUTRAL = 'neutral';

    const NAME_OPENING = 'Apertura de Caja';

    const CODE_OPENING = 'apertura';

    const NAME_CLOSING = 'Cierre de Caja';

    const CODE_CLOSING = 'cierre';

    const NAME_POLICY_PAYMENT = 'Cobro de Póliza';

    const CODE_POLICY_PAYMENT = 'cobro_poliza';

    const NAME_MANUAL_INCOME = 'Ingreso Manual / Remesa';

    const CODE_MANUAL_INCOME = 'ingreso_manual';

    const NAME_COLLECTOR_SETTLEMENT = 'Rendición de Recaudador';

    const CODE_COLLECTOR_SETTLEMENT = 'ingreso_recaudador';

    const NAME_TREASURY_TRANSFER = 'Retiro a Tesorería';

    const CODE_TREASURY_TRANSFER = 'retiro_tesoreria';

    const NAME_SERVICE_PAYMENT = 'Pago de Servicios';

    const CODE_SERVICE_PAYMENT = 'pago_servicio';

    const NAME_OPERATING_EXPENSE = 'Gasto Operativo Menor';

    const CODE_OPERATING_EXPENSE = 'gasto_operativo';

    const NAME_SURPLUS_ADJUSTMENT = 'Ajuste Sobrante en Arqueo';

    const CODE_SURPLUS_ADJUSTMENT = 'ajuste_sobrante';

    const NAME_DEFICIT_ADJUSTMENT = 'Ajuste Faltante en Arqueo';

    const CODE_DEFICIT_ADJUSTMENT = 'ajuste_faltante';

    protected $fillable = [
        'name',
        'code',
        'default_effect',
        'description',
    ];

    public function movements(): HasMany
    {
        return $this->hasMany(CashMovement::class);
    }
}
