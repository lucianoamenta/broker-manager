<?php

namespace App\Models;

use App\Traits\FindsByIdOrUuid;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Office extends Model
{
    use FindsByIdOrUuid, HasFactory, HasUuid, SoftDeletes;

    protected $fillable = [
        'uuid',
        'zone_id',
        'name',
        'code',
        'description',
        'phone',
        'email',
        'address',
        'city_id',
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
     * Zona territorial a la que pertenece la oficina.
     */
    public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class);
    }

    /**
     * Organización matriz inferida a través de la zona.
     */
    public function organization(): HasOneThrough
    {
        return $this->hasOneThrough(
            Organization::class,
            Zone::class,
            'id',              // Clave foránea en zones (id)
            'id',              // Clave foránea en organizations (id)
            'zone_id',         // Clave local en offices
            'organization_id'  // Clave local en zones
        );
    }

    /**
     * Ciudad / Localidad de radicación.
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Cajas registradoras asignadas a esta oficina.
     */
    public function cashRegisters(): HasMany
    {
        return $this->hasMany(CashRegister::class);
    }

    /**
     * Cajeros asignados a esta oficina.
     */
    public function cashiers(): HasMany
    {
        return $this->hasMany(Cashier::class);
    }

    /**
     * Representantes o encargados asignados a esta oficina.
     */
    public function representatives(): HasMany
    {
        return $this->hasMany(OfficeRepresentative::class);
    }
}
