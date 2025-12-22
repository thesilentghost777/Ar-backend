<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'enonce',
        'image_url',
        'type',
        'explication',
        'ordre',
        'points',
        'active'
    ];

    protected $casts = [
        'ordre' => 'integer',
        'points' => 'integer',
        'active' => 'boolean'
    ];

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function reponses(): HasMany
    {
        return $this->hasMany(Reponse::class)->orderBy('ordre');
    }

    public function bonneReponse()
    {
        return $this->reponses()->where('est_correcte', true)->first();
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
