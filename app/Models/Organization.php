<?php

namespace App\Models;

use App\Traits\FindsByIdOrUuid;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use FindsByIdOrUuid, HasFactory, HasUuid, SoftDeletes;

    protected $fillable = [
        'uuid',
        'name',
        'legal_name',
        'cuit',
        'code',
        'email',
        'phone',
        'address',
        'city_id',
        'web_url',
        'url_logo',
        'is_active',
        'settings',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'settings' => 'array',
        ];
    }

    /**
     * Relación con la ciudad sede de la organización.
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Zonas territoriales pertenecientes a la organización.
     */
    public function zones(): HasMany
    {
        return $this->hasMany(Zone::class);
    }

    /**
     * Departamentos funcionales de la organización.
     */
    public function departments(): HasMany
    {
        return $this->hasMany(Department::class);
    }

    /**
     * Oficinas operativas pertenecientes a las zonas de la organización.
     */
    public function offices(): HasManyThrough
    {
        return $this->hasManyThrough(Office::class, Zone::class);
    }

    /**
     * Representantes corporativos de la organización.
     */
    public function representatives(): HasMany
    {
        return $this->hasMany(OrganizationRepresentative::class);
    }

    /**
     * Recaudadores dependientes de la organización.
     */
    public function collectors(): HasMany
    {
        return $this->hasMany(Collector::class);
    }
}
