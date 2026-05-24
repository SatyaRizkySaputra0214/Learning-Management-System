<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'LMS Bahasa') }}</title>
    <script>
        // Set default theme to dark, and persist theme across page navigation
        (function() {
            const userPreference = "{{ auth()->user()->theme_preference ?? 'dark' }}";
            const storedTheme = localStorage.getItem('appearance');
            // Use stored theme if available, otherwise use user preference (default: dark)
            const theme = storedTheme || userPreference || 'dark';

            let setDark = () => document.documentElement.classList.add('dark');
            let setLight = () => document.documentElement.classList.remove('dark');

            if (theme === 'system') {
                const media = window.matchMedia('(prefers-color-scheme: dark)');
                localStorage.removeItem('appearance');
                media.matches ? setDark() : setLight();
            } else if (theme === 'dark') {
                localStorage.setItem('appearance', 'dark');
                setDark();
            } else if (theme === 'light') {
                localStorage.setItem('appearance', 'light');
                setLight();
            }
        })();
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Perbaikan Dark Mode - Background tidak terlalu menyala dan Kontras Tinggi */
        .dark body, 
        .dark main,
        .dark .bg-gray-50,
        .dark .bg-gray-900 {
            background-color: #0f172a !important; /* Deep Slate Blue - Lebih gelap dan elegan */
        }

        .dark .bg-white,
        .dark .bg-gray-800 {
            background-color: #1e293b !important; /* Slate 800 */
        }

        .dark .border-gray-200,
        .dark .border-gray-700 {
            border-color: #334155 !important; /* Slate 700 */
        }

        /* Memastikan teks terlihat dengan warna yang kontras */
        .dark .text-gray-800,
        .dark .text-gray-900,
        .dark .text-white,
        .dark h1,
        .dark h2,
        .dark h3,
        .dark p {
            color: #f1f5f9 !important; /* Slate 100 - Putih tulang yang jelas */
        }

        .dark .text-gray-500,
        .dark .text-gray-400 {
            color: #94a3b8 !important; /* Slate 400 - Abu-abu yang masih terbaca */
        }

        /* Warna Aksen untuk elemen interaktif */
        .dark .text-blue-600,
        .dark .text-blue-400 {
            color: #60a5fa !important; /* Sky blue yang terang */
        }

        .dark .bg-blue-50,
        .dark .bg-blue-900\/30 {
            background-color: rgba(30, 58, 138, 0.4) !important;
        }

        /* Perbaikan Kontras Tabel */
        .dark table thead tr {
            background-color: #334155 !important;
        }
        
        .dark table tbody tr:hover {
            background-color: #1e293b !important;
        }
    </style>
</head>

<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 antialiased" x-data="{
    sidebarOpen: localStorage.getItem('sidebarOpen') === null ? window.innerWidth >= 1024 : (localStorage.getItem('sidebarOpen') === 'true' && window.innerWidth >= 1024),
    toggleSidebar() {
        this.sidebarOpen = !this.sidebarOpen;
        localStorage.setItem('sidebarOpen', this.sidebarOpen);
    },
}">

    <div class="min-h-screen flex flex-col">
        <!-- Top Header -->
        <header class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700 z-10">
            <div class="flex items-center justify-between px-4 py-3">
                <div class="flex items-center gap-3">
                    <button @click="toggleSidebar()"
                            class="lg:hidden p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('Logo.png') }}" alt="Logo" class="w-10 h-10 object-contain">
                        <div>
                            <h1 class="text-xl font-bold text-gray-800 dark:text-white">KHRUFAI</h1>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Learning Management System</p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <!-- Theme Toggle -->
                    <button onclick="toggleTheme()"
                            class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <svg x-show="!document.documentElement.classList.contains('dark')" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                        <svg x-show="document.documentElement.classList.contains('dark')" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </button>
                    <script>
                        function toggleTheme() {
                            const isDark = document.documentElement.classList.contains('dark');
                            const newTheme = isDark ? 'light' : 'dark';
                            localStorage.setItem('appearance', newTheme);
                            if (isDark) {
                                document.documentElement.classList.remove('dark');
                            } else {
                                document.documentElement.classList.add('dark');
                            }
                        }
                    </script>

                    <!-- User Menu -->
                    <div class="flex items-center gap-3" x-data="{ open: false }">
                        <div class="hidden md:block text-right">
                            <p class="text-sm font-medium text-gray-800 dark:text-white">{{ auth()->user()->nama_lengkap }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 capitalize">{{ auth()->user()->role }}</p>
                        </div>
                        <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold">
                            {{ strtoupper(substr(auth()->user()->nama_lengkap, 0, 1)) }}
                        </div>
                        <button @click="open = !open" class="p-1 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <!-- Dropdown -->
                        <div x-show="open"
                             @click.away="open = false"
                             class="absolute right-4 top-16 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 py-1 z-50">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="flex flex-1 overflow-hidden">
            <!-- Sidebar -->
            <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
                   class="fixed inset-y-0 left-0 z-20 w-64 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 transform transition-transform duration-300 lg:translate-x-0 lg:static lg:inset-0">
                <nav class="mt-4 px-3 space-y-1">
                    {{ $sidebar }}
                </nav>
            </aside>

            <!-- Overlay for mobile -->
            <div x-show="sidebarOpen"
                 @click="toggleSidebar()"
                 class="fixed inset-0 bg-black bg-opacity-50 z-10 lg:hidden"></div>

            <!-- Main Content -->
            <main class="flex-1 overflow-auto bg-gray-50 dark:bg-gray-900">
                <div class="p-6">
                    @if(session('success'))
                        <div x-data="{ show: true }" x-show="show"
                             class="mb-6 bg-green-50 dark:bg-green-900/30 border-l-4 border-green-500 p-4 rounded-md">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 101.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-green-700 dark:text-green-300">{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div x-data="{ show: true }" x-show="show"
                             class="mb-6 bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 p-4 rounded-md">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-red-700 dark:text-red-300">{{ session('error') }}</span>
                            </div>
                        </div>
                    @endif

                    @if($errors->any())
                        <div x-data="{ show: true }" x-show="show"
                             class="mb-6 bg-yellow-50 dark:bg-yellow-900/30 border-l-4 border-yellow-500 p-4 rounded-md">
                            <ul class="list-disc list-inside text-yellow-700 dark:text-yellow-300 text-sm">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
</body>

</html>
