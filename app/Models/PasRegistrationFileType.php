<?php

namespace App\Models;

use App\Models\Traits\HasCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PasRegistrationFileType extends Model
{
    use HasCode, HasFactory;

    const NAME_SSN_CREDENTIAL = 'Credencial Matrícula SSN';

    const CODE_SSN_CREDENTIAL = 'credencial_ssn';

    const NAME_PROFESSIONAL_SURETY = 'Póliza de Caución Profesional';

    const CODE_PROFESSIONAL_SURETY = 'caucion_profesional';

    const NAME_AFIP_REGISTRATION = 'Constancia de Inscripción AFIP';

    const CODE_AFIP_REGISTRATION = 'inscripcion_afip';

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
        return $this->hasMany(PasRegistrationFile::class);
    }
}
