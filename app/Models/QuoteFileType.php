<?php

namespace App\Models;

use App\Models\Traits\HasCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuoteFileType extends Model
{
    use HasCode, HasFactory;

    const NAME_INSURER_PROPOSAL = 'Propuesta / Presupuesto de Aseguradora';

    const CODE_INSURER_PROPOSAL = 'propuesta_aseguradora';

    const NAME_VEHICLE_INSPECTION_PHOTO = 'Foto / Inspección Previa de Vehículo';

    const CODE_VEHICLE_INSPECTION_PHOTO = 'foto_inspeccion_vehiculo';

    const NAME_SIGNED_APPLICATION_FORM = 'Formulario de Solicitud Firmado';

    const CODE_SIGNED_APPLICATION_FORM = 'formulario_solicitud';

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
        return $this->hasMany(QuoteFile::class);
    }
}
