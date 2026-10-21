<?php

namespace App\Models;

use App\Traits\FindsByIdOrUuid;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrganizationInsurer extends Model
{
    use FindsByIdOrUuid, HasFactory, HasUuid, SoftDeletes;

    protected $table = 'organization_insurers';

    protected $fillable = [
        'uuid',
        'organization_id',
        'insurer_id',
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

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function insurer(): BelongsTo
    {
        return $this->belongsTo(Insurer::class);
    }
}
