<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // <-- ajouter ceci

class AutoEcoleUser extends Authenticatable
{
    use HasApiTokens,HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'nom',
        'prenom',
        'telephone',
        'password',
        'date_naissance',
        'quartier',
        'type_permis',
        'type_cours',
        'vague',
        'session_id',
        'centre_examen_id',
        'code_parrainage',
        'parrain_id',
        'niveau_parrainage',
        'solde',
        'validated',
        'cours_debloques',
        'status_frais_formation',
        'status_frais_inscription',
        'status_examen_blanc',
        'status_frais_examen',
        'description_paiement_formation',
        'description_paiement_inscription',
        'description_paiement_examen_blanc',
        'description_paiement_examen',
        'premier_depot_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'date_naissance' => 'date',
        'solde' => 'decimal:2',
        'validated' => 'boolean',
        'cours_debloques' => 'boolean',
        'premier_depot_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Relations
    public function session()
    {
        return $this->belongsTo(Session::class, 'session_id');
    }

    public function centreExamen()
    {
        return $this->belongsTo(CentreExamen::class, 'centre_examen_id');
    }

    public function parrain()
    {
        return $this->belongsTo(AutoEcoleUser::class, 'parrain_id');
    }

    public function filleuls()
    {
        return $this->hasMany(AutoEcoleUser::class, 'parrain_id');
    }

    public function lieuxPratique()
    {
        return $this->belongsToMany(
            LieuPratique::class,
            'user_lieux_pratique',
            'user_id',
            'lieu_pratique_id'
        )->withTimestamps();
    }

    public function paiements()
    {
        return $this->hasMany(AutoEcolePaiement::class, 'user_id');
    }

    public function notifications()
    {
        return $this->hasMany(AutoEcoleNotification::class, 'user_id');
    }

    public function progressionLecons()
    {
        return $this->hasMany(ProgressionLecon::class, 'user_id');
    }

    public function resultatsQuiz()
    {
        return $this->hasMany(ResultatQuiz::class, 'user_id');
    }

    // Accesseur
    public function getNomCompletAttribute()
    {
        return "{$this->prenom} {$this->nom}";
    }

    // Scopes
    public function scopeValide($query)
    {
        return $query->where('validated', true);
    }

    public function scopeCoursDebloques($query)
    {
        return $query->where('cours_debloques', true);
    }

    public function scopeParTypePermis($query, $type)
    {
        return $query->where('type_permis', $type);
    }

    public function scopeParVague($query, $vague)
    {
        return $query->where('vague', $vague);
    }

    // Méthodes utilitaires
    public function aPayeFormation()
    {
        return $this->status_frais_formation === 'paye' || $this->status_frais_formation === 'dispense';
    }

    public function aPayeInscription()
    {
        return $this->status_frais_inscription === 'paye' || $this->status_frais_inscription === 'dispense';
    }

    public function aPayeExamenBlanc()
    {
        return $this->status_examen_blanc === 'paye' || $this->status_examen_blanc === 'dispense';
    }

    public function aPayeExamen()
    {
        return $this->status_frais_examen === 'paye' || $this->status_frais_examen === 'dispense';
    }

    public function peutAccederCours()
    {
        return $this->validated && $this->cours_debloques;
    }

    public function getLieuxPratiqueNoms()
    {
        return $this->lieuxPratique->pluck('nom')->join(', ') ?: 'Aucun';
    }
}
