<?php


// app/Models/Chapitre.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapitre extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'nom',
        'description',
        'ordre',
        'active',
    ];

    protected $casts = [
        'ordre' => 'integer',
        'active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relations
    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function lecons()
    {
        return $this->hasMany(Lecon::class)->orderBy('ordre');
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

    // Méthodes utilitaires
    public function nombreLecons()
    {
        return $this->lecons()->count();
    }

    public function dureeTotale()
    {
        return $this->lecons()->sum('duree_minutes');
    }

    public function quiz()
{
    return $this->hasMany(Quiz::class);
}

}

