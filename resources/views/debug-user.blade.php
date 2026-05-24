<x-layouts.lms>
    <x-slot name="sidebar">
        @include('layouts.sidebar-guru')
    </x-slot>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Debug: User Info</h1>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <h2 class="text-lg font-semibold mb-4">Your User Info:</h2>
        
        <dl class="space-y-3">
            <div>
                <dt class="text-sm text-gray-500 dark:text-gray-400">ID</dt>
                <dd class="text-gray-800 dark:text-white">{{ auth()->id() }}</dd>
            </div>
            <div>
                <dt class="text-sm text-gray-500 dark:text-gray-400">Username</dt>
                <dd class="text-gray-800 dark:text-white">{{ auth()->user()->username }}</dd>
            </div>
            <div>
                <dt class="text-sm text-gray-500 dark:text-gray-400">Nama Lengkap</dt>
                <dd class="text-gray-800 dark:text-white">{{ auth()->user()->nama_lengkap }}</dd>
            </div>
            <div>
                <dt class="text-sm text-gray-500 dark:text-gray-400">Email</dt>
                <dd class="text-gray-800 dark:text-white">{{ auth()->user()->email }}</dd>
            </div>
            <div>
                <dt class="text-sm text-gray-500 dark:text-gray-400">Role</dt>
                <dd>
                    <span class="px-3 py-1 rounded-full text-sm font-semibold
                        @if(auth()->user()->role === 'guru') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                        @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                        @endif">
                        {{ auth()->user()->role }}
                    </span>
                </dd>
            </div>
            <div>
                <dt class="text-sm text-gray-500 dark:text-gray-400">Is Guru?</dt>
                <dd>
                    @if(auth()->user()->isGuru())
                        <span class="text-green-600 dark:text-green-400">✅ YES</span>
                    @else
                        <span class="text-red-600 dark:text-red-400">❌ NO - You are not a guru!</span>
                    @endif
                </dd>
            </div>
        </dl>

        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
            <h3 class="text-md font-semibold mb-3">Quick Links:</h3>
            <div class="space-y-2">
                <a href="{{ route('guru.dashboard') }}" class="block bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg transition">
                    Go to Dashboard
                </a>
                <a href="{{ route('guru.classes.index') }}" class="block bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-lg transition">
                    Go to Classes
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-lg transition">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-layouts.lms>
