<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Session extends Model
{
    use HasFactory;

    protected $table = 'sessions1';

    protected $fillable = [
        'nom',
        'date_communication_enregistrement',
        'date_enregistrement_vague1',
        'date_enregistrement_vague2',
        'date_transfert_reconduction',
        'date_depot_departemental',
        'date_depot_regional',
        'date_examen_theorique',
        'date_examen_pratique',
        'active'
    ];

    protected $casts = [
        'date_communication_enregistrement' => 'date',
        'date_enregistrement_vague1' => 'date',
        'date_enregistrement_vague2' => 'date',
        'date_transfert_reconduction' => 'date',
        'date_depot_departemental' => 'date',
        'date_depot_regional' => 'date',
        'date_examen_theorique' => 'date',
        'date_examen_pratique' => 'date',
        'active' => 'boolean'
    ];

    public function users(): HasMany
    {
        return $this->hasMany(AutoEcoleUser::class);
    }

    public function scopeActives($query)
    {
        return $query->where('active', true);
    }

    public function scopeRecentes($query, $limit = 4)
    {
        return $query->orderBy('date_examen_theorique', 'desc')->limit($limit);
    }

    /**
     * Vérifie si la session est disponible pour inscription
     * Une session est disponible si la date limite d'enregistrement n'est pas encore passée
     */
    public function disponiblePourInscription(): bool
    {
        if (!$this->active) {
            return false;
        }

        $aujourdhui = Carbon::today();

        // Vérifier si au moins une des dates d'enregistrement n'est pas encore passée
        $vague1Disponible = $this->date_enregistrement_vague1 &&
                            Carbon::parse($this->date_enregistrement_vague1)->isFuture();

        $vague2Disponible = $this->date_enregistrement_vague2 &&
                            Carbon::parse($this->date_enregistrement_vague2)->isFuture();

        return $vague1Disponible || $vague2Disponible;
    }

    /**
     * Scope pour récupérer uniquement les sessions disponibles pour inscription
     */
    public function scopeDisponiblesPourInscription($query)
    {
        return $query->where('active', true)
                    ->where(function($q) {
                        $q->where('date_enregistrement_vague1', '>=', Carbon::today())
                          ->orWhere('date_enregistrement_vague2', '>=', Carbon::today());
                    });
    }
}
