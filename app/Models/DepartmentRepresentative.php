<?php

namespace App\Models;

use App\Traits\FindsByIdOrUuid;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DepartmentRepresentative extends Model
{
    use FindsByIdOrUuid, HasFactory, HasUuid, SoftDeletes;

    const POSITION_TREASURER = 'tesorero';

    const POSITION_ACCOUNTANT = 'contador';

    const POSITION_AUDITOR = 'auditor';

    const POSITION_LAWYER = 'abogado';

    const POSITION_MARKETING = 'marketing';

    protected $fillable = [
        'uuid',
        'department_id',
        'user_id',
        'full_name',
        'cuit',
        'personal_email',
        'personal_phone',
        'position',
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
     * Departamento funcional representado.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Usuario de autenticación del representante de departamento.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
