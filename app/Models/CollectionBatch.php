<?php

namespace App\Models;

use App\Traits\FindsByIdOrUuid;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class CollectionBatch extends Model
{
    use FindsByIdOrUuid, HasFactory, HasUuid, SoftDeletes;

    const STATUS_IN_PROGRESS = 'en_curso';

    const STATUS_CLOSED = 'cerrado';

    const STATUS_SETTLED = 'rendido_a_tesoreria';

    const STATUS_AUDITED = 'auditado';

    protected $fillable = [
        'uuid',
        'collector_id',
        'organization_id',
        'started_at',
        'closed_at',
        'total_collected_amount',
        'status',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'closed_at' => 'datetime',
            'total_collected_amount' => 'decimal:2',
        ];
    }

    public function collector(): BelongsTo
    {
        return $this->belongsTo(Collector::class);
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function settlement(): HasOne
    {
        return $this->hasOne(CollectionSettlement::class);
    }
}
