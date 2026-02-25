<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class UserCni extends Model
{
    use SoftDeletes;

    protected $table = 'user_cni';

    protected $fillable = [
        'user_id',
        'cni_recto_path',
        'cni_verso_path',
        'statut',
        'motif_rejet',
        'soumis_at',
        'traite_at',
        'traite_par',
    ];

    protected $casts = [
        'soumis_at' => 'datetime',
        'traite_at' => 'datetime',
    ];

    // ─── Relations ──────────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(AutoEcoleUser::class, 'user_id');
    }

    public function traitePar()
    {
        return $this->belongsTo(Admin::class, 'traite_par');
    }

    // ─── Accesseurs URLs ─────────────────────────────────────────

    public function getCniRectoUrlAttribute(): ?string
    {
        return $this->cni_recto_path
            ? Storage::disk('public')->url($this->cni_recto_path)
            : null;
    }

    public function getCniVersoUrlAttribute(): ?string
    {
        return $this->cni_verso_path
            ? Storage::disk('public')->url($this->cni_verso_path)
            : null;
    }

    // ─── Helpers ─────────────────────────────────────────────────

    public function estComplet(): bool
    {
        return !is_null($this->cni_recto_path) && !is_null($this->cni_verso_path);
    }

    public function estValide(): bool
    {
        return $this->statut === 'valide';
    }
}