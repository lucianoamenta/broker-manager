<?php

namespace App\Models;

use App\Models\Traits\HasCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InsurerFileType extends Model
{
    use HasCode, HasFactory;

    const NAME_FRAMEWORK_AGREEMENT = 'Contrato Marco con Broker';

    const CODE_FRAMEWORK_AGREEMENT = 'contrato_marco';

    const NAME_SSN_AUTHORIZATION = 'Resolución de Autorización SSN';

    const CODE_SSN_AUTHORIZATION = 'resolucion_ssn';

    const NAME_UNDERWRITING_MANUAL = 'Manual de Suscripción';

    const CODE_UNDERWRITING_MANUAL = 'manual_suscripcion';

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
        return $this->hasMany(InsurerFile::class);
    }
}
