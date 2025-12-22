<?php
// app/Models/Module.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
        'type',
        'type_permis',
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
    public function chapitres()
    {
        return $this->hasMany(Chapitre::class)->orderBy('ordre');
    }

    // Scopes
    public function scopeActif($query)
    {
        return $query->where('active', true);
    }

    public function scopeTheorique($query)
    {
        return $query->where('type', 'theorique');
    }

    public function scopePratique($query)
    {
        return $query->where('type', 'pratique');
    }

    public function scopeParTypePermis($query, $type)
    {
        return $query->where(function ($q) use ($type) {
            $q->where('type_permis', $type)
              ->orWhere('type_permis', 'tous');
        });
    }

    public function scopeOrdonne($query)
    {
        return $query->orderBy('ordre');
    }

    // Méthodes utilitaires
    public function nombreChapitres()
    {
        return $this->chapitres()->count();
    }

    public function nombreLecons()
    {
        return Lecon::whereHas('chapitre', function ($query) {
            $query->where('module_id', $this->id);
        })->count();
    }
}
