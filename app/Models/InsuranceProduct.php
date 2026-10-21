<?php

namespace App\Models;

use App\Models\Traits\HasCode;
use App\Traits\FindsByIdOrUuid;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class InsuranceProduct extends Model
{
    use FindsByIdOrUuid, HasCode, HasFactory, HasUuid, SoftDeletes;

    protected $fillable = [
        'uuid',
        'insurer_id',
        'insurance_branch_id',
        'name',
        'code',
        'description',
        'is_active',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * Compañía aseguradora propietaria del producto.
     */
    public function insurer(): BelongsTo
    {
        return $this->belongsTo(Insurer::class);
    }

    /**
     * Ramo al que pertenece el producto.
     */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(InsuranceBranch::class, 'insurance_branch_id');
    }

    /**
     * Cotizaciones formuladas con este producto.
     */
    public function quotes(): HasMany
    {
        return $this->hasMany(Quote::class);
    }

    /**
     * Pólizas emitidas con este producto.
     */
    public function policies(): HasMany
    {
        return $this->hasMany(Policy::class);
    }
}
