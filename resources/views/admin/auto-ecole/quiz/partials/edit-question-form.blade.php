<form action="{{ route('admin.auto-ecole.questions.update', $question->id) }}" method="POST">
    @csrf
    @method('PUT')
    @include('admin.auto-ecole.quiz.partials.question-form', ['question' => $question])
</form>
