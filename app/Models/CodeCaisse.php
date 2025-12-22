<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CodeCaisse extends Model
{
    use HasFactory;

    protected $table = 'codes_caisse';

    protected $fillable = [
        'code',
        'user_id',
        'montant',
        'utilise',
        'utilise_at',
        'expire_at',
        'cree_par'
    ];

    protected $casts = [
        'montant' => 'decimal:2',
        'utilise' => 'boolean',
        'utilise_at' => 'datetime',
        'expire_at' => 'datetime'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(AutoEcoleUser::class, 'user_id');
    }

    public function createur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cree_par');
    }

    public static function genererCode(): string
    {
        return 'CC-' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 10));
    }

    public function estValide(): bool
    {
        if ($this->utilise) {
            return false;
        }

        if ($this->expire_at && now()->greaterThan($this->expire_at)) {
            return false;
        }

        return true;
    }
}
