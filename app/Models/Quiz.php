<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
    use HasFactory;

    protected $table = 'quiz';

    protected $fillable = [
        'chapitre_id',
        'titre',
        'description',
        'note_passage',
        'duree_minutes',
        'ordre',
        'active'
    ];

    protected $casts = [
        'chapitre_id' => 'integer',
        'note_passage' => 'integer',
        'duree_minutes' => 'integer',
        'ordre' => 'integer',
        'active' => 'boolean'
    ];

    public function chapitre(): BelongsTo
    {
        return $this->belongsTo(Chapitre::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class)->orderBy('ordre');
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
