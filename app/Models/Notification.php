<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use HasFactory;
    use HasUuid;
    use SoftDeletes;

    // Eventos admitidos por la App
    const EVENT_NEWS = 'news';

    const EVENT_PROMOTION = 'promotion';

    // Títulos predefinidos que se pueden usar
    const TITLE_NEWS = '¡Nueva Notificación!';

    const TITLE_PROMOTION = '¡Oferta Especial!';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'title',
        'body',
        'description',
        'payload',
        'event',
        'url_image',
        'is_read',
        'user_id',
    ];

    protected $casts = [
        'payload' => 'array',
        'is_read' => 'boolean',
    ];

    /**
     * Relación con el Usuario (Owner de la notificación)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scopes para filtrar
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }
}
