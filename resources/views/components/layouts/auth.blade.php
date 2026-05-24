<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - {{ config('app.name') }}</title>
    @vite('resources/css/app.css')
    <script>
        // Set default theme to dark, and persist theme across page navigation
        (function() {
            const storedTheme = localStorage.getItem('appearance');
            // Use stored theme if available, otherwise default to dark
            const theme = storedTheme || 'dark';
            
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
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200 antialiased" x-data="{
    darkMode: localStorage.getItem('appearance') === 'dark' || localStorage.getItem('appearance') === null,
    toggleDarkMode() {
        this.darkMode = !this.darkMode;
        localStorage.setItem('appearance', this.darkMode ? 'dark' : 'light');
        if (this.darkMode) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    }
}"
    :class="{ 'dark': darkMode }">

    <div class="min-h-screen flex flex-col">
        <!-- Main Content -->
        <main class="flex-1 flex items-center justify-center p-6">
            <div class="w-full max-w-md">
                {{ $slot }}
            </div>
        </main>
    </div>
</body>

</html>
