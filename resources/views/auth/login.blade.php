@extends('components.layouts.auth-simple')

@section('title', 'Login - LMS Bahasa')

@section('content')
<div class="w-full max-w-md">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 border border-gray-200 dark:border-gray-700">
        <div class="text-center mb-8">
            <div class="flex items-center justify-center mx-auto mb-4">
                <img src="{{ asset('Logo.png') }}" alt="Logo" class="w-20 h-20 object-contain">
            </div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">LMS Khrufai</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-2">Silakan login untuk melanjutkan</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf
            
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Username
                </label>
                <input type="text" 
                       id="username" 
                       name="username" 
                       value="{{ old('username') }}"
                       required 
                       autofocus
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('username') border-red-500 @enderror">
                @error('username')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Password
                </label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       required 
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('password') border-red-500 @enderror">
                @error('password')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Ingat saya</span>
                </label>
            </div>

            <button type="submit" 
                    class="w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold py-3 rounded-lg hover:from-blue-600 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200">
                Login
            </button>
        </form>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Belum punya akun?
                <a href="{{ route('registration.create') }}" class="text-blue-600 dark:text-blue-400 hover:underline font-medium">
                    Daftar sekarang
                </a>
            </p>
        </div>
    </div>
</div>
@endsection
