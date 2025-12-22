<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserLieuPratique extends Model
{
    use HasFactory;

    protected $table = 'user_lieux_pratique';

    protected $fillable = [
        'auto_ecole_user_id',
        'lieu_pratique_id',
    ];

    public function autoEcoleUser(): BelongsTo
    {
        return $this->belongsTo(AutoEcoleUser::class);
    }

    public function lieuPratique(): BelongsTo
    {
        return $this->belongsTo(LieuPratique::class);
    }
}
