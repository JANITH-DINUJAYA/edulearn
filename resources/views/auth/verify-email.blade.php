<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-violet-100 via-purple-50 to-fuchsia-100 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md">

            <!-- Email Icon -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-violet-500 to-purple-600 rounded-full shadow-lg mb-4 animate-bounce">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76"/>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Verify Your Email</h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">You're almost there!</p>
            </div>

            <!-- Verification Card -->
            <div class="bg-white dark:bg-slate-800 shadow-2xl rounded-2xl overflow-hidden border border-gray-200 dark:border-slate-700">

                <!-- Success Message (if resent) -->
                @if (session('status') == 'verification-link-sent')
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border-l-4 border-green-500 p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800 dark:text-green-200">
                                Email Sent Successfully!
                            </p>
                            <p class="mt-1 text-xs text-green-700 dark:text-green-300">
                                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                            </p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Main Content -->
                <div class="p-8">
                    <!-- Welcome Message -->
                    <div class="mb-6 bg-violet-50 dark:bg-violet-900/20 border border-violet-200 dark:border-violet-800 rounded-lg p-4">
                        <div class="flex gap-3">
                            <svg class="w-6 h-6 text-violet-600 dark:text-violet-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <p class="text-sm font-semibold text-violet-900 dark:text-violet-200 mb-1">Thanks for signing up!</p>
                                <p class="text-sm text-violet-800 dark:text-violet-300">
                                    {{ __('Before getting started, please verify your email address by clicking on the link we just emailed to you. If you didn\'t receive the email, we will gladly send you another.') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Verification Steps -->
                    <div class="mb-6">
                        <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">What to do next:</h3>
                        <div class="space-y-3">
                            <div class="flex items-start gap-3 p-3 bg-gray-50 dark:bg-slate-700/50 rounded-lg">
                                <div class="flex-shrink-0 w-6 h-6 bg-violet-100 dark:bg-violet-900/50 rounded-full flex items-center justify-center">
                                    <span class="text-xs font-bold text-violet-600 dark:text-violet-400">1</span>
                                </div>
                                <p class="text-sm text-gray-700 dark:text-gray-300">Check your email inbox (and spam folder)</p>
                            </div>
                            <div class="flex items-start gap-3 p-3 bg-gray-50 dark:bg-slate-700/50 rounded-lg">
                                <div class="flex-shrink-0 w-6 h-6 bg-violet-100 dark:bg-violet-900/50 rounded-full flex items-center justify-center">
                                    <span class="text-xs font-bold text-violet-600 dark:text-violet-400">2</span>
                                </div>
                                <p class="text-sm text-gray-700 dark:text-gray-300">Open the email from us</p>
                            </div>
                            <div class="flex items-start gap-3 p-3 bg-gray-50 dark:bg-slate-700/50 rounded-lg">
                                <div class="flex-shrink-0 w-6 h-6 bg-violet-100 dark:bg-violet-900/50 rounded-full flex items-center justify-center">
                                    <span class="text-xs font-bold text-violet-600 dark:text-violet-400">3</span>
                                </div>
                                <p class="text-sm text-gray-700 dark:text-gray-300">Click the verification button in the email</p>
                            </div>
                            <div class="flex items-start gap-3 p-3 bg-gray-50 dark:bg-slate-700/50 rounded-lg">
                                <div class="flex-shrink-0 w-6 h-6 bg-violet-100 dark:bg-violet-900/50 rounded-full flex items-center justify-center">
                                    <span class="text-xs font-bold text-violet-600 dark:text-violet-400">4</span>
                                </div>
                                <p class="text-sm text-gray-700 dark:text-gray-300">Start your learning journey!</p>
                            </div>
                        </div>
                    </div>

                    <!-- Resend Email Form -->
                    <form method="POST" action="{{ route('verification.send') }}" class="mb-4">
                        @csrf
                        <x-primary-button class="w-full justify-center bg-gradient-to-r from-violet-600 to-purple-600 hover:from-violet-700 hover:to-purple-700 text-white font-semibold py-3 px-4 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            {{ __('Resend Verification Email') }}
                        </x-primary-button>
                    </form>

                    <!-- Divider -->
                    <div class="relative my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300 dark:border-slate-600"></div>
                        </div>
                        <div class="relative flex justify-center text-xs">
                            <span class="px-2 bg-white dark:bg-slate-800 text-gray-500 dark:text-gray-400">or</span>
                        </div>
                    </div>

                    <!-- Logout Form -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex justify-center items-center py-3 px-4 border-2 border-gray-300 dark:border-slate-600 rounded-lg shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-slate-700 hover:bg-gray-50 dark:hover:bg-slate-600 transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            {{ __('Sign Out') }}
                        </button>
                    </form>
                </div>
            </div>

            <!-- Help Section -->
            <div class="mt-6 space-y-4">
                <!-- Email Not Received -->
                <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-amber-600 dark:text-amber-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-amber-900 dark:text-amber-200 mb-1">Didn't receive the email?</p>
                            <ul class="text-xs text-amber-800 dark:text-amber-300 space-y-1 list-disc list-inside">
                                <li>Check your spam or junk folder</li>
                                <li>Make sure you entered the correct email address</li>
                                <li>Wait a few minutes and check again</li>
                                <li>Click "Resend Verification Email" above</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Email Benefits -->
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-blue-900 dark:text-blue-200 mb-1">Why verify your email?</p>
                            <p class="text-xs text-blue-800 dark:text-blue-300">Email verification helps us keep your account secure and ensures you receive important updates about your courses and learning progress.</p>
                        </div>
                    </div>
                </div>

                <!-- Support Contact -->
                <div class="text-center">
                    <p class="text-xs text-gray-600 dark:text-gray-400">
                        Still having trouble?
                        <a href="#" class="text-violet-600 hover:text-violet-500 dark:text-violet-400 font-medium inline-flex items-center">
                            Contact Support
                            <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </a>
                    </p>
                </div>
            </div>

            <!-- Security Note -->
            <div class="mt-6 bg-gray-50 dark:bg-slate-800/50 border border-gray-200 dark:border-slate-700 rounded-lg p-4">
                <div class="flex items-center justify-center gap-2 text-xs text-gray-600 dark:text-gray-400">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    <span>Verification links expire after 60 minutes for security</span>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
