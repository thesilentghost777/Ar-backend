<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JourPratique extends Model
{
    use HasFactory;

    protected $table = 'jours_pratique';

    protected $fillable = [
        'lieu_pratique_id',
        'jour',
        'heure_debut',
        'heure_fin',
        'active',
    ];

    protected $casts = [
        'heure_debut' => 'datetime:H:i',
        'heure_fin' => 'datetime:H:i',
        'active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relations
    public function lieuPratique()
    {
        return $this->belongsTo(LieuPratique::class, 'lieu_pratique_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeParJour($query, $jour)
    {
        return $query->where('jour', $jour);
    }

    // Accesseurs
    public function getJourFormateAttribute()
    {
        return ucfirst($this->jour);
    }

    public function getHoraireAttribute()
    {
        return $this->heure_debut->format('H:i') . ' - ' . $this->heure_fin->format('H:i');
    }
}
