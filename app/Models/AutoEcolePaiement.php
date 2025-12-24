<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AutoEcolePaiement extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'destinataire_id',
        'montant',
        'type_paiement',
        'type',
        'tranche',
        'transaction_id',
        'reference',
        'statut',
        'status',
        'methode_paiement',
        'methode',
        'notes',
        'description',
        'date_paiement',
        'solde_avant',
        'solde_apres',
        'frais_type',
        'token_pay', // Ajouté
        'transaction_externe' // Ajouté
    ];
    protected $casts = [
        'montant' => 'decimal:2',
        'solde_avant' => 'decimal:2',
        'solde_apres' => 'decimal:2',
        'date_paiement' => 'datetime'
    ];
    // Relations
    public function user(): BelongsTo
    {
        return $this->belongsTo(AutoEcoleUser::class, 'user_id');
    }
    /**
     * Relation vers le destinataire du transfert
     */
    public function destinataire(): BelongsTo
    {
        return $this->belongsTo(AutoEcoleUser::class, 'destinataire_id');
    }
    // Helpers - Génération de références uniques
    /**
     * Génère un identifiant de transaction unique
     */
    public static function genererTransactionId(): string
    {
        return 'TXN-' . now()->format('YmdHis') . '-' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 8));
    }
    /**
     * Génère une référence de paiement unique
     */
    public static function genererReference(): string
    {
        return 'REF-' . now()->format('YmdHis') . '-' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 8));
    }
    // Scopes utiles
    public function scopeValides($query)
    {
        return $query->where('status', 'valide')
                    ->orWhere('statut', 'valide');
    }
    public function scopeDepots($query)
    {
        return $query->where('type', 'depot')
                    ->orWhere('type_paiement', 'depot');
    }
    public function scopeRetraits($query)
    {
        return $query->where('type', 'retrait')
                    ->orWhere('type_paiement', 'retrait');
    }
    public function scopeTransferts($query)
    {
        return $query->whereIn('type', ['transfert_entrant', 'transfert_sortant']);
    }
    public function scopePaiementsFrais($query)
    {
        return $query->where('type', 'paiement_frais');
    }
}