<x-layouts.lms>
    <x-slot name="sidebar">
        @include('layouts.sidebar-murid')
    </x-slot>

    <div class="max-w-4xl mx-auto px-1" x-data="quizNavigation({{ $quiz->questions->count() }})">
        {{-- Back Link --}}
        <a href="{{ route('murid.enrolled-classes.show', $quiz->meeting->class) }}"
           class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 transition-colors mb-4 group">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Kelas
        </a>

        {{-- Quiz Header Card --}}
        <div class="quiz-card bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-6 mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex-1 min-w-0">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white truncate">{{ $quiz->judul_kuis }}</h1>
                    <div class="flex items-center gap-2 mt-2">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-medium bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                            {{ $quiz->skill->nama_skill }}
                        </span>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-gray-50 dark:bg-gray-700/50 text-sm font-semibold text-gray-700 dark:text-gray-300 whitespace-nowrap">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        {{ $quiz->questions->count() }} Soal
                    </span>
                </div>
            </div>
        </div>

        {{-- Info & Progress Card --}}
        <div class="quiz-card bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-5 mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                <div class="flex items-center gap-3 flex-1">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wider">Informasi Kuis</p>
                        <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Total <span class="text-blue-600 dark:text-blue-400">{{ $quiz->questions->count() }}</span> soal &mdash; Pilih jawaban terbaik untuk setiap soal</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-right">
                        <p class="text-xs font-medium text-gray-400 dark:text-gray-500">Progress</p>
                        <p class="text-sm font-bold text-gray-700 dark:text-gray-300" x-text="`${answeredCount} / {{ $quiz->questions->count() }}`">0 / {{ $quiz->questions->count() }}</p>
                    </div>
                    <div class="w-24 sm:w-32 h-2 bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden">
                        <div class="h-full bg-blue-500 rounded-full transition-all duration-500 ease-out"
                             :style="`width: ${(answeredCount / {{ $quiz->questions->count() }}) * 100}%`"
                             style="width: 0%"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Question Number Navigation --}}
        <div class="quiz-card bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-4 mb-6">
            <div class="flex flex-wrap gap-2 justify-center">
                @foreach($quiz->questions as $index => $question)
                    <button type="button"
                            @click="goToQuestion({{ $index }})"
                            :class="{
                                'nav-pill active': activeQuestion === {{ $index }},
                                'nav-pill': activeQuestion !== {{ $index }}
                            }"
                            class="nav-pill">
                        {{ $index + 1 }}
                    </button>
                @endforeach
            </div>
        </div>

        {{-- Questions Form --}}
        <form id="quizForm" action="{{ route('murid.quiz.submit', $quiz) }}" method="POST">
            @csrf

            @foreach($quiz->questions as $index => $question)
                <div id="question-{{ $index }}"
                     x-show="activeQuestion === {{ $index }}"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 translate-y-4"
                     class="quiz-card bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-6 mb-6">
                    {{-- Question Header --}}
                    <div class="flex items-start gap-4 mb-6">
                        <span class="flex-shrink-0 w-10 h-10 bg-blue-600 text-white rounded-xl flex items-center justify-center font-bold text-base shadow-sm">
                            {{ $index + 1 }}
                        </span>
                        <div class="flex-1 min-w-0 pt-1">
                            <p class="text-lg font-semibold text-gray-900 dark:text-white leading-relaxed whitespace-pre-wrap">{{ str_replace('[[NEWLINE]]', "\n", $question->soal) }}</p>
                            @if($question->gambar_soal)
                                <img src="{{ Storage::url($question->gambar_soal) }}" alt="Gambar soal" class="mt-4 max-w-md rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                            @endif
                        </div>
                    </div>

                    {{-- Options --}}
                    <div class="space-y-3">
                        @foreach(['A', 'B', 'C', 'D'] as $option)
                            <label class="quiz-option">
                                <input type="radio"
                                       name="answers[{{ $question->id }}]"
                                       value="{{ $option }}"
                                       required
                                       @change="markAnswered({{ $question->id }}, true)"
                                       class="hidden">
                                <div class="quiz-radio">
                                    <div class="quiz-radio-dot"></div>
                                </div>
                                <span class="flex items-center gap-3 flex-1 min-w-0 text-gray-700 dark:text-gray-300 font-medium">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-700 text-sm font-bold text-gray-500 dark:text-gray-400 flex-shrink-0"> {{ $option }} </span>
                                    <span class="leading-relaxed">{{ $question->{"opsi_" . strtolower($option)} }}</span>
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach

            {{-- Footer Actions --}}
            <div class="quiz-card bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-4 mb-6">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                    <a href="{{ route('murid.enrolled-classes.show', $quiz->meeting->class) }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl border-2 border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-semibold text-sm hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-500 transition-all duration-200 w-full sm:w-auto justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Kembali
                    </a>
                    <div class="flex items-center gap-3 w-full sm:w-auto">
                        <button type="button"
                                @click="goToQuestion(activeQuestion - 1)"
                                x-show="activeQuestion > 0"
                                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border-2 border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-semibold text-sm hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-500 transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Sebelumnya
                        </button>
                        <button type="button"
                                @click="goToQuestion(activeQuestion + 1)"
                                x-show="activeQuestion < totalQuestions - 1"
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm shadow-sm hover:shadow-md active:scale-[0.97] transition-all duration-200">
                            Selanjutnya
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                        <button type="submit"
                                x-show="activeQuestion === totalQuestions - 1"
                                class="btn-submit inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm shadow-sm hover:shadow-md transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Submit Jawaban
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        function quizNavigation(totalQuestions) {
            return {
                activeQuestion: 0,
                totalQuestions: totalQuestions,
                answered: {},
                answeredCount: 0,

                markAnswered(questionId, answered) {
                    if (answered && !this.answered[questionId]) {
                        this.answered[questionId] = true;
                        this.answeredCount = Object.keys(this.answered).length;
                    }
                },

                goToQuestion(index) {
                    if (index < 0 || index >= this.totalQuestions) return;
                    this.activeQuestion = index;
                    this.$nextTick(() => {
                        const el = document.getElementById('question-' + index);
                        if (el) {
                            el.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }
                    });
                }
            };
        }
    </script>
</x-layouts.lms>
