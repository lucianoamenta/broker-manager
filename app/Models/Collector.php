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

class Collector extends Model
{
    use FindsByIdOrUuid, HasFactory, HasUuid, SoftDeletes;

    protected $fillable = [
        'uuid',
        'organization_id',
        'user_id',
        'code',
        'full_name',
        'cuit',
        'personal_phone',
        'personal_email',
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
     * Organización de la cual depende este recaudador.
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Cuenta de usuario vinculada al recaudador.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Zonas asignadas por las que transita y recauda.
     */
    public function zones(): BelongsToMany
    {
        return $this->belongsToMany(Zone::class, 'collector_zones')
            ->withPivot(['id', 'uuid', 'assigned_at', 'assigned_by_user_id', 'deleted_at'])
            ->withTimestamps();
    }

    /**
     * Registros de asignación intermedia a zonas.
     */
    public function collectorZones(): HasMany
    {
        return $this->hasMany(CollectorZone::class);
    }
}
