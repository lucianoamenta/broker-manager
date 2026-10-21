<?php

namespace App\Models;

use App\Traits\FindsByIdOrUuid;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Party extends Model
{
    use FindsByIdOrUuid, HasFactory, HasUuid, SoftDeletes;

    const TAX_TYPE_CUIT = 'cuit';

    const TAX_TYPE_CUIL = 'cuil';

    const TAX_TYPE_DNI = 'dni';

    const TAX_TYPE_PASSPORT = 'pasaporte';

    protected $fillable = [
        'uuid',
        'user_id',
        'is_individual',
        'first_name',
        'last_name',
        'legal_name',
        'tax_id_type',
        'tax_id',
        'fiscal_condition_id',
        'gender_id',
        'marital_status_id',
        'birth_date',
        'personal_email',
        'personal_phone',
        'address',
        'city_id',
        'is_active',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_individual' => 'boolean',
            'is_active' => 'boolean',
            'birth_date' => 'date',
        ];
    }

    /**
     * Nombre completo o Razón Social según corresponda.
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->is_individual
            ? trim(($this->first_name ?? '').' '.($this->last_name ?? ''))
            : ($this->legal_name ?? '');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function fiscalCondition(): BelongsTo
    {
        return $this->belongsTo(FiscalCondition::class);
    }

    public function gender(): BelongsTo
    {
        return $this->belongsTo(Gender::class);
    }

    public function maritalStatus(): BelongsTo
    {
        return $this->belongsTo(MaritalStatus::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Bienes o riesgos registrados a nombre del cliente.
     */
    public function insuredRisks(): HasMany
    {
        return $this->hasMany(InsuredRisk::class);
    }

    /**
     * Cotizaciones solicitadas o registradas para este cliente.
     */
    public function quotes(): HasMany
    {
        return $this->hasMany(Quote::class);
    }

    /**
     * Pólizas donde participa (a través de policy_parties).
     */
    public function policyParties(): HasMany
    {
        return $this->hasMany(PolicyParty::class);
    }

    /**
     * Pagos realizados por este cliente.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Comprobantes emitidos a nombre de este cliente.
     */
    public function vouchers(): HasMany
    {
        return $this->hasMany(Voucher::class);
    }
}
