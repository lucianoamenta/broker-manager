<?php

namespace App\Models;

use App\Traits\FindsByIdOrUuid;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PasRegistration extends Model
{
    use FindsByIdOrUuid, HasFactory, HasUuid, SoftDeletes;

    protected $fillable = [
        'uuid',
        'user_id',
        'full_name',
        'cuit',
        'registration_number',
        'is_individual',
        'email',
        'phone',
        'address',
        'city_id',
        'valid_from',
        'valid_until',
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
            'valid_from' => 'date',
            'valid_until' => 'date',
        ];
    }

    /**
     * Usuario vinculado si tiene acceso al sistema.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Ciudad del domicilio del productor.
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Asignaciones organizacionales / zonales de esta matrícula.
     */
    public function organizationAssignments(): HasMany
    {
        return $this->hasMany(OrganizationPasAssignment::class);
    }

    /**
     * Organizaciones a las que está asignada esta matrícula.
     */
    public function organizations(): BelongsToMany
    {
        return $this->belongsToMany(Organization::class, 'organization_pas_assignments')
            ->withPivot(['zone_id', 'is_active'])
            ->withTimestamps();
    }

    /**
     * Convenios con aseguradoras firmados bajo esta matrícula.
     */
    public function agreements(): HasMany
    {
        return $this->hasMany(InsurerAgreement::class);
    }

    /**
     * Pólizas emitidas intermediadas con esta matrícula.
     */
    public function policies(): HasMany
    {
        return $this->hasMany(Policy::class);
    }

    /**
     * Archivos adjuntos (credencial SSN, constancia de inscripción).
     */
    public function files(): HasMany
    {
        return $this->hasMany(PasRegistrationFile::class);
    }
}
