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

class Quote extends Model
{
    use FindsByIdOrUuid, HasFactory, HasUuid, SoftDeletes;

    const STATUS_DRAFT = 'borrador';

    const STATUS_PRESENTED = 'presentada';

    const STATUS_ACCEPTED = 'aceptada';

    const STATUS_REJECTED = 'rechazada';

    const STATUS_CONVERTED = 'convertida_en_poliza';

    const STATUS_EXPIRED = 'vencida';

    protected $fillable = [
        'uuid',
        'organization_id',
        'office_id',
        'party_id',
        'insurer_id',
        'insurance_branch_id',
        'insurance_product_id',
        'pas_registration_id',
        'insured_risk_id',
        'sum_insured',
        'premium_net',
        'taxes_amount',
        'total_amount',
        'installments_count',
        'valid_until',
        'quote_snapshot',
        'status',
        'created_by_user_id',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'sum_insured' => 'decimal:2',
            'premium_net' => 'decimal:2',
            'taxes_amount' => 'decimal:2',
            'total_amount' => 'decimal:2',
            'installments_count' => 'integer',
            'valid_until' => 'date',
            'quote_snapshot' => 'array',
        ];
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function office(): BelongsTo
    {
        return $this->belongsTo(Office::class);
    }

    public function party(): BelongsTo
    {
        return $this->belongsTo(Party::class);
    }

    public function insurer(): BelongsTo
    {
        return $this->belongsTo(Insurer::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(InsuranceBranch::class, 'insurance_branch_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(InsuranceProduct::class, 'insurance_product_id');
    }

    public function pasRegistration(): BelongsTo
    {
        return $this->belongsTo(PasRegistration::class);
    }

    public function insuredRisk(): BelongsTo
    {
        return $this->belongsTo(InsuredRisk::class);
    }

    public function createdByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    /**
     * Eventos comerciales del ciclo de vida de la cotización.
     */
    public function events(): HasMany
    {
        return $this->hasMany(QuoteEvent::class);
    }

    /**
     * Póliza que se emitió a partir de esta cotización (si fue tomada).
     */
    public function policy(): HasOne
    {
        return $this->hasOne(Policy::class);
    }

    /**
     * Archivos adjuntos a la cotización (fotos, formularios).
     */
    public function files(): HasMany
    {
        return $this->hasMany(QuoteFile::class);
    }
}
