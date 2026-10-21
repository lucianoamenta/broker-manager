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

class Zone extends Model
{
    use FindsByIdOrUuid, HasFactory, HasUuid, SoftDeletes;

    protected $fillable = [
        'uuid',
        'organization_id',
        'name',
        'code',
        'description',
        'email',
        'phone',
        'url_logo',
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
     * Organización a la que pertenece la zona.
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Oficinas operativas radicadas en esta zona.
     */
    public function offices(): HasMany
    {
        return $this->hasMany(Office::class);
    }

    /**
     * Representantes o supervisores asignados a esta zona.
     */
    public function representatives(): HasMany
    {
        return $this->hasMany(ZoneRepresentative::class);
    }

    /**
     * Recaudadores habilitados para operar en esta zona.
     */
    public function collectors(): BelongsToMany
    {
        return $this->belongsToMany(Collector::class, 'collector_zones')
            ->withPivot(['id', 'uuid', 'assigned_at', 'assigned_by_user_id', 'deleted_at'])
            ->withTimestamps();
    }

    /**
     * Asignaciones intermedias de recaudadores.
     */
    public function collectorZones(): HasMany
    {
        return $this->hasMany(CollectorZone::class);
    }
}
