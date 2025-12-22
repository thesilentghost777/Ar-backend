<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResultatQuiz extends Model
{
    use HasFactory;

    protected $table = 'resultats_quiz';

    protected $fillable = [
        'user_id',
        'quiz_id',           // ✅ Changé de chapitre_id
        'note',              // ✅ Changé de score
        'total_questions',   // ✅ Ajouté
        'bonnes_reponses',   // ✅ Ajouté
        'reussi',
        'reponses_utilisateur', // ✅ Ajouté
        'tentative'          // ✅ Ajouté
    ];

    protected $casts = [
        'note' => 'decimal:2',        // ✅ Changé de score
        'total_questions' => 'integer',
        'bonnes_reponses' => 'integer',
        'reussi' => 'boolean',
        'reponses_utilisateur' => 'array', // ✅ Pour le JSON
        'tentative' => 'integer'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(AutoEcoleUser::class, 'user_id');
    }

    public function quiz(): BelongsTo  // ✅ Changé de chapitre()
    {
        return $this->belongsTo(Quiz::class);
    }

    // Si vous avez besoin d'accéder au chapitre
    public function chapitre(): BelongsTo
    {
        return $this->quiz->chapitre();
    }
}
