@php
    $isFrench = true;

    // Préparer les réponses pour Alpine.js
    $reponsesData = old('reponses');

    if (!$reponsesData && isset($question) && $question->reponses) {
        $reponsesData = $question->reponses->map(function($r) {
            return ['texte' => $r->texte, 'est_correcte' => (bool)$r->est_correcte];
        })->toArray();
    }

    if (!$reponsesData) {
        $reponsesData = [
            ['texte' => '', 'est_correcte' => false],
            ['texte' => '', 'est_correcte' => false]
        ];
    }
@endphp

<div x-data="questionForm()" class="space-y-6">
    <!-- Énoncé -->
    <div>
        <label for="enonce" class="block text-sm font-semibold text-gray-700 mb-2">
            <i class="fas fa-question text-purple-600 mr-2"></i>
            {{ $isFrench ? 'Énoncé de la question' : 'Question statement' }} *
        </label>
        <textarea name="enonce"
                  id="enonce"
                  required
                  rows="3"
                  placeholder="{{ $isFrench ? 'Ex: Quelle est la signification d\'un panneau octogonal rouge ?' : 'Ex: What is the meaning of a red octagonal sign?' }}"
                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition-all duration-200">{{ old('enonce', $question->enonce ?? '') }}</textarea>
    </div>

    <!-- Type et Points -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="type" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-list text-blue-600 mr-2"></i>
                {{ $isFrench ? 'Type de question' : 'Question type' }} *
            </label>
            <select name="type"
                    id="type"
                    required
                    x-model="questionType"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition-all duration-200">
                <option value="qcm">{{ $isFrench ? 'QCM (Choix multiples)' : 'Multiple choice' }}</option>
                <option value="vrai_faux">{{ $isFrench ? 'Vrai/Faux' : 'True/False' }}</option>
            </select>
        </div>

        <div>
            <label for="points" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-star text-amber-600 mr-2"></i>
                {{ $isFrench ? 'Points' : 'Points' }} *
            </label>
            <input type="number"
                   name="points"
                   id="points"
                   required
                   min="1"
                   value="{{ old('points', $question->points ?? 1) }}"
                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition-all duration-200">
        </div>
    </div>

    <!-- Image URL -->
    <div>
        <label for="image_url" class="block text-sm font-semibold text-gray-700 mb-2">
            <i class="fas fa-image text-green-600 mr-2"></i>
            {{ $isFrench ? 'URL de l\'image (optionnelle)' : 'Image URL (optional)' }}
        </label>
        <input type="url"
               name="image_url"
               id="image_url"
               value="{{ old('image_url', $question->image_url ?? '') }}"
               placeholder="https://example.com/image.jpg"
               class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition-all duration-200">
    </div>

    <!-- Réponses -->
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-4">
            <i class="fas fa-list text-blue-600 mr-2"></i>
            {{ $isFrench ? 'Réponses' : 'Answers' }} *
            <span class="text-xs text-gray-500 font-normal ml-2">
                ({{ $isFrench ? 'Cochez la ou les réponses correctes' : 'Check the correct answer(s)' }})
            </span>
        </label>

        <div class="space-y-3" id="reponses-container">
            <template x-for="(reponse, index) in reponses" :key="index">
                <div class="bg-gray-50 rounded-lg p-4 border-2 border-gray-200">
                    <div class="flex items-start gap-3">
                        <div class="flex items-center pt-2">
                            <input type="checkbox"
                                   :id="`reponse_correcte_${index}`"
                                   :name="`reponses[${index}][est_correcte]`"
                                   value="1"
                                   x-model="reponse.est_correcte"
                                   class="w-5 h-5 text-green-600 border-gray-300 rounded focus:ring-green-500">
                        </div>
                        <div class="flex-1">
                            <input type="text"
                                   :name="`reponses[${index}][texte]`"
                                   x-model="reponse.texte"
                                   required
                                   :placeholder="'{{ $isFrench ? 'Réponse' : 'Answer' }} ' + (index + 1)"
                                   class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition-all duration-200">
                        </div>
                        <button type="button"
                                @click="removeReponse(index)"
                                x-show="reponses.length > (questionType === 'vrai_faux' ? 2 : 2)"
                                class="text-red-600 hover:text-red-800 hover:bg-red-50 p-2 rounded transition-colors">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    <p class="text-xs text-gray-500 mt-2 ml-8">
                        {{ $isFrench ? 'Cochez si cette réponse est correcte' : 'Check if this answer is correct' }}
                    </p>
                </div>
            </template>
        </div>

        <button type="button"
                @click="addReponse"
                x-show="questionType === 'qcm' || (questionType === 'vrai_faux' && reponses.length < 2)"
                class="mt-4 inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 font-semibold rounded-lg hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200">
            <i class="fas fa-plus mr-2"></i>
            {{ $isFrench ? 'Ajouter une réponse' : 'Add answer' }}
        </button>
    </div>

    <!-- Explication -->
    <div>
        <label for="explication" class="block text-sm font-semibold text-gray-700 mb-2">
            <i class="fas fa-info-circle text-blue-600 mr-2"></i>
            {{ $isFrench ? 'Explication (optionnelle)' : 'Explanation (optional)' }}
        </label>
        <textarea name="explication"
                  id="explication"
                  rows="3"
                  placeholder="{{ $isFrench ? 'Expliquez pourquoi c\'est la bonne réponse...' : 'Explain why this is the correct answer...' }}"
                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition-all duration-200">{{ old('explication', $question->explication ?? '') }}</textarea>
    </div>

    <!-- Actions -->
    <div class="flex gap-4 pt-4 border-t border-gray-200">
        <button type="submit"
                class="flex-1 bg-gradient-to-r from-purple-600 to-purple-700 text-white px-6 py-3 rounded-lg font-semibold hover:from-purple-700 hover:to-purple-800 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-all duration-200 shadow-lg">
            <i class="fas fa-save mr-2"></i>
            {{ $isFrench ? 'Enregistrer la question' : 'Save question' }}
        </button>

        <button type="button"
                @click="$dispatch('close-modal')"
                class="flex-1 bg-gray-100 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200">
            <i class="fas fa-times mr-2"></i>
            {{ $isFrench ? 'Annuler' : 'Cancel' }}
        </button>
    </div>
</div>

<script>
function questionForm() {
    return {
        questionType: '{{ old('type', $question->type ?? 'qcm') }}',
        reponses: [],

        init() {
            // Initialiser les réponses avec conversion en booléen
            const reponsesData = @json($reponsesData);
            this.reponses = reponsesData.map(r => ({
                texte: r.texte || '',
                est_correcte: Boolean(r.est_correcte)
            }));

            // Watcher pour le type de question
            this.$watch('questionType', (value) => {
                if (value === 'vrai_faux') {
                    if (this.reponses.length > 2) {
                        this.reponses = this.reponses.slice(0, 2);
                    }
                    if (this.reponses.length < 2) {
                        while (this.reponses.length < 2) {
                            this.reponses.push({ texte: '', est_correcte: false });
                        }
                    }
                }
            });
        },

        addReponse() {
            if (this.questionType === 'qcm') {
                this.reponses.push({ texte: '', est_correcte: false });
            } else if (this.questionType === 'vrai_faux' && this.reponses.length < 2) {
                this.reponses.push({ texte: '', est_correcte: false });
            }
        },

        removeReponse(index) {
            const minLength = this.questionType === 'vrai_faux' ? 2 : 2;
            if (this.reponses.length > minLength) {
                this.reponses.splice(index, 1);
            }
        }
    }
}
</script>
