<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LieuPratique extends Model
{
    use HasFactory;

    protected $table = 'lieux_pratique';

    protected $fillable = [
        'nom',
        'adresse',
        'ville',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relations
    public function joursPratique()
    {
        return $this->hasMany(JourPratique::class, 'lieu_pratique_id');
    }

    public function users()
    {
        return $this->belongsToMany(
            AutoEcoleUser::class,
            'user_lieux_pratique',
            'lieu_pratique_id',
            'user_id'
        )->withTimestamps();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    // Accesseur pour affichage complet
    public function getAdresseCompleteAttribute()
    {
        $parts = array_filter([$this->adresse, $this->ville]);
        return !empty($parts) ? implode(', ', $parts) : 'Adresse non renseignée';
    }
}
