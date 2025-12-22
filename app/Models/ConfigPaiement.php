<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigPaiement extends Model
{
    use HasFactory;

    protected $table = 'config_paiements';

    protected $fillable = [
        'frais_formation',
        'frais_inscription',
        'frais_examen_blanc',
        'frais_examen',
        'depot_minimum',
        'code_parrainage_defaut',
        'whatsapp_support',
        'lien_telechargement_app'
    ];

    protected $casts = [
        'frais_formation' => 'decimal:2',
        'frais_inscription' => 'decimal:2',
        'frais_examen_blanc' => 'decimal:2',
        'frais_examen' => 'decimal:2',
        'depot_minimum' => 'decimal:2'
    ];

    public static function getConfig()
    {
        return self::firstOrCreate([]);
    }
}
