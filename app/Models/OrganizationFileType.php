<?php

namespace App\Models;

use App\Models\Traits\HasCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrganizationFileType extends Model
{
    use HasCode, HasFactory;

    const NAME_SOCIAL_STATUTE = 'Estatuto Constitutivo';

    const CODE_SOCIAL_STATUTE = 'estatuto_social';

    const NAME_TAX_REGISTRATION = 'Constancia de CUIT / ARCA';

    const CODE_TAX_REGISTRATION = 'constancia_cuit';

    const NAME_POWER_OF_ATTORNEY = 'Poder de Representación';

    const CODE_POWER_OF_ATTORNEY = 'poder_representacion';

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
        return $this->hasMany(OrganizationFile::class);
    }
}
