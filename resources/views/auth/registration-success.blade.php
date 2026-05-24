@extends('components.layouts.auth-simple')

@section('title', 'Pendaftaran Berhasil - LMS Bahasa')

@section('content')
<div class="w-full max-w-md">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 border border-gray-200 dark:border-gray-700 text-center">
        <div class="w-20 h-20 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
        </div>
        
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">Pendaftaran Berhasil!</h1>
        <p class="text-gray-600 dark:text-gray-400 mb-6">
            Terima kasih telah mendaftar. Admin akan memverifikasi pembayaran Anda. Setelah diverifikasi, Anda akan menerima informasi login.
        </p>
        
        <a href="{{ route('login') }}" 
           class="inline-block bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold px-8 py-3 rounded-lg hover:from-blue-600 hover:to-purple-700 transition duration-200">
            Kembali ke Login
        </a>
    </div>
</div>
@endsection
