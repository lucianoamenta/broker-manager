<?php

namespace App\Models;

use App\Traits\FindsByIdOrUuid;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CollectionSettlement extends Model
{
    use FindsByIdOrUuid, HasFactory, HasUuid, SoftDeletes;

    const STATUS_COMPLETE = 'recibido_completo';

    const STATUS_WITH_DIFFERENCE = 'recibido_con_diferencia';

    const STATUS_OBSERVED = 'observado';

    protected $fillable = [
        'uuid',
        'collection_batch_id',
        'department_id',
        'delivered_by_user_id',
        'received_by_user_id',
        'delivered_amount',
        'received_amount',
        'difference',
        'settled_at',
        'status',
        'settlement_notes',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'delivered_amount' => 'decimal:2',
            'received_amount' => 'decimal:2',
            'difference' => 'decimal:2',
            'settled_at' => 'datetime',
        ];
    }

    public function batch(): BelongsTo
    {
        return $this->belongsTo(CollectionBatch::class, 'collection_batch_id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function deliveredByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'delivered_by_user_id');
    }

    public function receivedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'received_by_user_id');
    }
}
