<?php

namespace App\Models;

use App\Traits\FindsByIdOrUuid;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuoteEvent extends Model
{
    use FindsByIdOrUuid, HasFactory, HasUuid, SoftDeletes;

    const EVENT_CREATION = 'creacion';

    const EVENT_SENT = 'envio_cliente';

    const EVENT_VIEWED = 'visto';

    const EVENT_ACCEPTED = 'aceptada';

    const EVENT_INSPECTION_REQUESTED = 'inspeccion_solicitada';

    const EVENT_DOCS_ATTACHED = 'documentacion_adjunta';

    const EVENT_SENT_TO_ISSUE = 'enviada_a_emision';

    const EVENT_REJECTED = 'rechazada';

    protected $fillable = [
        'uuid',
        'quote_id',
        'event_type',
        'previous_status',
        'new_status',
        'notes',
        'performed_by_user_id',
        'payload',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'payload' => 'array',
        ];
    }

    public function quote(): BelongsTo
    {
        return $this->belongsTo(Quote::class);
    }

    public function performedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'performed_by_user_id');
    }
}
