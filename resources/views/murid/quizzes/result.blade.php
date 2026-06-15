<x-layouts.lms>
    <x-slot name="sidebar">
        @include('layouts.sidebar-murid')
    </x-slot>

    <div class="max-w-3xl mx-auto">
        {{-- Main Result Card --}}
        <div class="relative bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 p-10 md:p-14 text-center overflow-hidden">
            {{-- Decorative dot pattern --}}
            <div class="absolute -top-8 -right-8 w-48 h-48 opacity-[0.04] dark:opacity-[0.08] pointer-events-none">
                <svg width="100%" height="100%" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="dotPattern" x="0" y="0" width="10" height="10" patternUnits="userSpaceOnUse">
                            <circle cx="2" cy="2" r="1" fill="currentColor" class="text-blue-600"/>
                        </pattern>
                    </defs>
                    <rect width="100" height="100" fill="url(#dotPattern)"/>
                </svg>
            </div>

            {{-- Decorative dots bottom-left --}}
            <div class="absolute -bottom-6 -left-6 w-32 h-32 opacity-[0.03] dark:opacity-[0.06] pointer-events-none">
                <svg width="100%" height="100%" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="dotPattern2" x="0" y="0" width="14" height="14" patternUnits="userSpaceOnUse">
                            <circle cx="2" cy="2" r="1.5" fill="currentColor" class="text-blue-600"/>
                        </pattern>
                    </defs>
                    <rect width="100" height="100" fill="url(#dotPattern2)"/>
                </svg>
            </div>

            {{-- Success icon --}}
            <div class="relative mb-8">
                <div class="w-28 h-28 bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-800/30 rounded-full flex items-center justify-center mx-auto shadow-inner ring-4 ring-blue-50 dark:ring-blue-900/20">
                    <svg class="w-14 h-14 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                {{-- Sparkle icon near the circle --}}
                <div class="absolute -top-1 right-1/4 w-6 h-6 text-yellow-400 dark:text-yellow-300/70">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2l1.5 6.5L20 10l-6.5 1.5L12 18l-1.5-6.5L4 10l6.5-1.5L12 2z"/>
                    </svg>
                </div>
            </div>

            {{-- Quiz info --}}
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-gray-100 mb-2">{{ $score->quiz->judul_kuis }}</h2>
            <p class="text-gray-500 dark:text-gray-400 mb-10 flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                </svg>
                Skill: {{ $score->quiz->skill->nama_skill }}
            </p>

            {{-- Stat Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 max-w-lg mx-auto mb-10">
                <div class="bg-gray-50 dark:bg-gray-700/40 rounded-xl p-6 border border-gray-100 dark:border-gray-600/50 hover:shadow-md transition-shadow duration-200">
                    <div class="flex flex-col items-center gap-3">
                        <div class="w-11 h-11 bg-blue-100 dark:bg-blue-900/40 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Skor</p>
                            <p class="text-4xl font-extrabold text-blue-600 dark:text-blue-400 mt-1.5">{{ $score->skor }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700/40 rounded-xl p-6 border border-gray-100 dark:border-gray-600/50 hover:shadow-md transition-shadow duration-200">
                    <div class="flex flex-col items-center gap-3">
                        <div class="w-11 h-11 bg-emerald-100 dark:bg-emerald-900/40 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Jawaban Benar</p>
                            <p class="text-4xl font-extrabold text-emerald-600 dark:text-emerald-400 mt-1.5">{{ $score->total_poin }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Action Button --}}
            <a href="{{ route('murid.enrolled-classes.show', $score->quiz->meeting->class) }}"
               class="inline-flex items-center gap-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-9 py-3.5 rounded-xl font-semibold shadow-md hover:shadow-lg active:shadow-sm active:scale-[0.98] transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Kelas
            </a>

            {{-- Bottom accent line --}}
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-400 via-blue-600 to-blue-700 rounded-b-xl"></div>
        </div>
    </div>
</x-layouts.lms>
