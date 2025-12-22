<?php

// app/Models/Lecon.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecon extends Model
{
    use HasFactory;

    protected $fillable = [
        'chapitre_id',
        'titre',
        'contenu_texte',
        'url_web',
        'url_video',
        'ordre',
        'duree_minutes',
        'active',
    ];

    protected $casts = [
        'ordre' => 'integer',
        'duree_minutes' => 'integer',
        'active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relations
    public function chapitre()
    {
        return $this->belongsTo(Chapitre::class);
    }

    // Scopes
    public function scopeActif($query)
    {
        return $query->where('active', true);
    }

    public function scopeOrdonne($query)
    {
        return $query->orderBy('ordre');
    }

    public function scopeTheorique($query)
    {
        return $query->whereNotNull('url_web');
    }

    public function scopePratique($query)
    {
        return $query->whereNotNull('url_video');
    }

    // Accesseurs
    public function getTypeLeconAttribute()
    {
        if ($this->url_video) {
            return 'pratique';
        } elseif ($this->url_web) {
            return 'theorique';
        } elseif ($this->contenu_texte) {
            return 'texte';
        }
        return 'non_defini';
    }

    public function getDureeFormateeAttribute()
    {
        $heures = floor($this->duree_minutes / 60);
        $minutes = $this->duree_minutes % 60;

        if ($heures > 0) {
            return "{$heures}h " . ($minutes > 0 ? "{$minutes}min" : "");
        }
        return "{$minutes}min";
    }

    // Méthodes utilitaires
    public function estComplete()
    {
        return !empty($this->titre) &&
               ($this->contenu_texte || $this->url_web || $this->url_video);
    }
}
