<?php

namespace App\Models;

use App\Traits\FindsByIdOrUuid;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Policy extends Model
{
    use FindsByIdOrUuid, HasFactory, HasUuid, SoftDeletes;

    const PERIODICITY_MONTHLY = 'mensual';

    const PERIODICITY_BIMONTHLY = 'bimestral';

    const PERIODICITY_QUARTERLY = 'trimestral';

    const PERIODICITY_FOUR_MONTHLY = 'cuatrimestral';

    const PERIODICITY_SEMI_ANNUAL = 'semestral';

    const PERIODICITY_ANNUAL = 'anual';

    const STATUS_ACTIVE = 'vigente';

    const STATUS_SUSPENDED = 'suspendida';

    const STATUS_CANCELLED = 'anulada';

    const STATUS_EXPIRED = 'vencida';

    const STATUS_TERMINATED = 'cancelada';

    protected $fillable = [
        'uuid',
        'organization_id',
        'office_id',
        'insurer_id',
        'insurance_product_id',
        'pas_registration_id',
        'insurer_agreement_id',
        'quote_id',
        'policy_number',
        'endorsement_number',
        'start_date',
        'end_date',
        'issue_date',
        'billing_periodicity',
        'payment_method_type',
        'status',
        'total_sum_insured',
        'net_premium',
        'taxes_amount',
        'total_premium',
        'created_by_user_id',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'issue_date' => 'date',
            'total_sum_insured' => 'decimal:2',
            'net_premium' => 'decimal:2',
            'taxes_amount' => 'decimal:2',
            'total_premium' => 'decimal:2',
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

    public function insurer(): BelongsTo
    {
        return $this->belongsTo(Insurer::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(InsuranceProduct::class, 'insurance_product_id');
    }

    public function pasRegistration(): BelongsTo
    {
        return $this->belongsTo(PasRegistration::class);
    }

    public function agreement(): BelongsTo
    {
        return $this->belongsTo(InsurerAgreement::class, 'insurer_agreement_id');
    }

    public function quote(): BelongsTo
    {
        return $this->belongsTo(Quote::class);
    }

    public function createdByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function parties(): HasMany
    {
        return $this->hasMany(PolicyParty::class);
    }

    public function risks(): HasMany
    {
        return $this->hasMany(PolicyRisk::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(PolicyTransaction::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function vouchers(): HasMany
    {
        return $this->hasMany(Voucher::class);
    }

    public function files(): HasMany
    {
        return $this->hasMany(PolicyFile::class);
    }
}
