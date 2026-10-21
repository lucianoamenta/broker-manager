<?php

namespace App\Models;

use App\Traits\FindsByIdOrUuid;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CashMovementFile extends Model
{
    use FindsByIdOrUuid, HasFactory, HasUuid, SoftDeletes;

    protected $fillable = [
        'uuid',
        'cash_movement_id',
        'cash_movement_file_type_id',
        'url',
        'original_name',
        'version',
        'uploaded_by_user_id',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'version' => 'integer',
        ];
    }

    public function cashMovement(): BelongsTo
    {
        return $this->belongsTo(CashMovement::class);
    }

    public function fileType(): BelongsTo
    {
        return $this->belongsTo(CashMovementFileType::class, 'cash_movement_file_type_id');
    }

    public function uploadedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by_user_id');
    }
}
