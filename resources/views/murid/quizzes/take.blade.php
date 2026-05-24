<x-layouts.lms>
    <x-slot name="sidebar">
        @include('layouts.sidebar-murid')
    </x-slot>

    <div class="mb-6">
        <a href="{{ route('murid.enrolled-classes.show', $quiz->meeting->class) }}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm mb-4 inline-block">← Kembali ke Kelas</a>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $quiz->judul_kuis }}</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">Skill: {{ $quiz->skill->nama_skill }}</p>
    </div>

    @if($errors->any())
        <div class="mb-6 bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 p-4 rounded-md">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <span class="text-red-700 dark:text-red-300 font-medium">Ada soal yang belum dijawab!</span>
            </div>
            <ul class="mt-2 ml-7 text-sm text-red-600 dark:text-red-400 list-disc">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="quizForm" action="{{ route('murid.quiz.submit', $quiz) }}" method="POST" class="space-y-6">
        @csrf
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Informasi Kuis</h3>
                <div class="flex items-center gap-4">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded-full">
                        {{ $quiz->questions->count() }} Soal
                    </span>
                </div>
            </div>
        </div>

        @foreach($quiz->questions as $index => $question)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-start gap-3 mb-4">
                    <span class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm">
                        {{ $index + 1 }}
                    </span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800 dark:text-white text-lg">{{ $question->soal }}</p>
                        @if($question->gambar_soal)
                            <img src="{{ Storage::url($question->gambar_soal) }}" alt="Gambar soal" class="mt-3 max-w-md rounded-lg border border-gray-200 dark:border-gray-700">
                        @endif
                    </div>
                </div>

                <div class="space-y-3 ml-11">
                    @foreach(['A', 'B', 'C', 'D'] as $option)
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer transition">
                            <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option }}" required
                                   class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                            <span class="text-gray-700 dark:text-gray-300">
                                <span class="inline-block w-6 h-6 bg-gray-100 dark:bg-gray-700 rounded text-center leading-6 text-xs mr-2">{{ $option }}</span>
                                {{ $question->{"opsi_" . strtolower($option)} }}
                            </span>
                        </label>
                    @endforeach
                </div>
            </div>
        @endforeach

        <div class="flex items-center justify-between gap-4">
            <a href="{{ route('murid.enrolled-classes.show', $quiz->meeting->class) }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg transition font-medium">
                ← Batal
            </a>
            <button type="submit" 
                    class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg transition font-medium shadow-md">
                ✓ Submit Jawaban
            </button>
        </div>
    </form>
</x-layouts.lms>
