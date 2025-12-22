<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AutoEcoleNotification extends Model
{
    use HasFactory;

    protected $table = 'auto_ecole_notifications';

    protected $fillable = [
        'user_id',
        'titre',
        'message',
        'type',
        'lu',
        'data'
    ];

    protected $casts = [
        'lu' => 'boolean',
        'data' => 'array'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(AutoEcoleUser::class, 'user_id');
    }

    public function scopeNonLu($query)
    {
        return $query->where('lu', false);
    }

    public static function envoyer(int $userId, string $titre, string $message, string $type = 'info', array $data = []): self
    {
        return self::create([
            'user_id' => $userId,
            'titre' => $titre,
            'message' => $message,
            'type' => $type,
            'data' => $data
        ]);
    }
}
