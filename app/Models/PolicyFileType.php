<?php

namespace App\Models;

use App\Models\Traits\HasCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PolicyFileType extends Model
{
    use HasCode, HasFactory;

    const NAME_OFFICIAL_POLICY_FRONT = 'Frente de Póliza Oficial';

    const CODE_OFFICIAL_POLICY_FRONT = 'frente_poliza';

    const NAME_COVERAGE_CERTIFICATE = 'Certificado de Cobertura';

    const CODE_COVERAGE_CERTIFICATE = 'certificado_cobertura';

    const NAME_MERCOSUR_CARD = 'Tarjeta de Circulación Mercosur';

    const CODE_MERCOSUR_CARD = 'tarjeta_mercosur';

    const NAME_NON_REPETITION_CLAUSE = 'Cláusula de No Repetición';

    const CODE_NON_REPETITION_CLAUSE = 'clausula_no_repeticion';

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
        return $this->hasMany(PolicyFile::class);
    }
}
