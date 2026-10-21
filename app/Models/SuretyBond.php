<?php

namespace App\Models;

use App\Traits\FindsByIdOrUuid;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuretyBond extends Model
{
    use FindsByIdOrUuid, HasFactory, HasUuid, SoftDeletes;

    const GUARANTEE_RENTAL = 'alquiler';

    const GUARANTEE_TENDER = 'mantenimiento_oferta';

    const GUARANTEE_EXECUTION = 'ejecucion_contrato';

    const GUARANTEE_REPAIR_FUND = 'fondo_reparo';

    const GUARANTEE_CUSTOMS = 'aduanera';

    protected $fillable = [
        'uuid',
        'insured_risk_id',
        'beneficiary_party_id',
        'guarantee_type',
        'contract_number',
        'contract_subject',
        'contract_start_date',
        'contract_end_date',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'contract_start_date' => 'date',
            'contract_end_date' => 'date',
        ];
    }

    public function insuredRisk(): BelongsTo
    {
        return $this->belongsTo(InsuredRisk::class);
    }

    public function beneficiary(): BelongsTo
    {
        return $this->belongsTo(Party::class, 'beneficiary_party_id');
    }
}
