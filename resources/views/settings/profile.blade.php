<x-layouts.app>
    <!-- Breadcrumbs -->
    <div class="mb-6 flex items-center text-sm">
        <a href="{{ route('dashboard') }}"
            class="text-blue-600 dark:text-blue-400 hover:underline">{{ __('Dashboard') }}</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2 text-gray-400" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <a href="{{ route('settings.profile.edit') }}"
            class="text-blue-600 dark:text-blue-400 hover:underline">{{ __('Profile') }}</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2 text-gray-400" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-500 dark:text-gray-400">{{ __('Profile') }}</span>
    </div>

    <!-- Page Title -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('Profile') }}</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">{{ __('Update your name and email address') }}</p>
    </div>

    <div class="p-6">
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Sidebar Navigation -->
            @include('settings.partials.navigation')

            <!-- Profile Content -->
            <div class="flex-1">
                <div
                    class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
                    <div class="p-6">
                        <!-- Profile Form -->
                        <form class="max-w-md mb-10" action="{{ route('settings.profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <x-forms.input label="Name" name="name" type="text"
                                    value="{{ old('name', $user->name) }}" />
                            </div>

                            <div class="mb-6">
                                <x-forms.input label="Email" name="email" type="email"
                                    value="{{ old('email', $user->email) }}" />
                            </div>

                            <div>
                                <x-button type="primary">{{ __('Save') }}</x-button>
                            </div>
                        </form>

                        <!-- Delete Account Section -->
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6 mt-6">
                            <h2 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-1">
                                {{ __('Delete account') }}
                            </h2>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">
                                {{ __('Delete your account and all of its resources') }}
                            </p>
                            <x-confirm-modal
                                action="{{ route('settings.profile.destroy') }}"
                                title="{{ __('Delete account') }}"
                                message="{{ __('Are you sure you want to delete your account? All of your data will be permanently removed.') }}"
                                confirmText="{{ __('Delete account') }}"
                            >
                                <x-slot name="trigger">
                                    <button type="button" class="text-white font-medium py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors flex items-center justify-center cursor-pointer bg-red-600 hover:bg-red-700 focus:ring-red-500">
                                        {{ __('Delete account') }}
                                    </button>
                                </x-slot>
                            </x-confirm-modal>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
