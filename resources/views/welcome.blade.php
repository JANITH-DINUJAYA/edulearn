<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=0.8">
        <title>{{ config('app.name', 'EduLearn') }} — Master Your Future</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body x-data="{ roleModal: false }" class="bg-white dark:bg-slate-950 text-slate-900 dark:text-slate-100 antialiased">

<header class="sticky top-0 z-50 bg-white/80 dark:bg-slate-950/80 backdrop-blur-md border-b border-slate-100 dark:border-slate-800">
    <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
        <div class="flex items-center gap-2">
            <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-200 dark:shadow-none">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            </div>
            <span class="text-xl font-black tracking-tighter uppercase">Edu<span class="text-indigo-600">Learn</span></span>
        </div>

        <nav class="flex items-center gap-6">
            @auth
                <div class="flex items-center gap-4">
                    <span class="hidden md:block text-xs font-bold uppercase tracking-widest text-slate-400">Welcome, {{ auth()->user()->name }}</span>
                    <a href="/dashboard" class="text-sm font-bold px-6 py-2.5 bg-slate-900 dark:bg-white dark:text-slate-900 text-white rounded-full hover:scale-105 transition-transform">
                        Go to Dashboard
                    </a>
                </div>
            @else
                <a href="{{ route('login') }}" class="text-sm font-bold text-slate-600 dark:text-slate-400 hover:text-indigo-600 transition-colors">Login</a>
                <button @click="roleModal = true" class="text-sm font-bold px-6 py-2.5 bg-indigo-600 text-white rounded-full hover:shadow-lg hover:shadow-indigo-200 transition-all active:scale-95">
                    Start Learning
                </button>
            @endauth
        </nav>
    </div>
</header>

<main>
    {{-- Hero Section --}}
    <section class="relative pt-24 pb-32 overflow-hidden">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-full -z-10">
            <div class="absolute top-10 left-10 w-80 h-80 bg-indigo-400/20 rounded-full blur-[120px]"></div>
            <div class="absolute bottom-10 right-10 w-80 h-80 bg-purple-400/20 rounded-full blur-[120px]"></div>
        </div>

        <div class="max-w-7xl mx-auto px-6 text-center">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 dark:bg-indigo-900/30 border border-indigo-100 dark:border-indigo-800 mb-8 animate-fade-in">
                <span class="flex h-2 w-2 rounded-full bg-indigo-600 animate-ping"></span>
                <span class="text-[10px] font-black uppercase tracking-widest text-indigo-600 dark:text-indigo-400">Enrollment Open for 2026</span>
            </div>

            <h1 class="text-6xl md:text-8xl font-black text-slate-900 dark:text-white mb-8 tracking-tight leading-[1]">
                Master any skill with <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-600">Expert Guidance.</span>
            </h1>

            <p class="text-lg md:text-2xl text-slate-500 dark:text-slate-400 max-w-3xl mx-auto mb-12 font-medium leading-relaxed">
                Experience a high-performance ecosystem designed for the next generation. Whether you are a student striving for excellence or a teacher ready to inspire.
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-5">
                <button @click="roleModal = true" class="px-12 py-5 bg-indigo-600 text-white rounded-2xl font-bold shadow-2xl shadow-indigo-200 dark:shadow-none hover:bg-indigo-700 hover:-translate-y-1 transition-all text-lg">
                    Get Started Free
                </button>
                <a href="#features" class="px-12 py-5 bg-white dark:bg-slate-900 text-slate-900 dark:text-white border border-slate-200 dark:border-slate-700 rounded-2xl font-bold hover:bg-slate-50 transition-all text-lg">
                    Watch Demo
                </a>
            </div>
        </div>
    </section>

    {{-- Stats Section --}}
    <section class="max-w-6xl mx-auto px-6 mb-32">
        <div class="grid grid-cols-1 md:grid-cols-3 bg-white dark:bg-slate-900 rounded-[48px] shadow-2xl shadow-slate-200/60 dark:shadow-none border border-slate-100 dark:border-slate-800 divide-y md:divide-y-0 md:divide-x divide-slate-100 dark:divide-slate-800">
            <div class="p-12 text-center group">
                <h3 class="text-6xl font-black text-indigo-600 mb-2 group-hover:scale-110 transition-transform">12k+</h3>
                <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Global Learners</p>
            </div>
            <div class="p-12 text-center group">
                <h3 class="text-6xl font-black text-indigo-600 mb-2 group-hover:scale-110 transition-transform">450+</h3>
                <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Curated Courses</p>
            </div>
            <div class="p-12 text-center group">
                <h3 class="text-6xl font-black text-indigo-600 mb-2 group-hover:scale-110 transition-transform">99%</h3>
                <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Success Rate</p>
            </div>
        </div>
    </section>

    {{-- Visual Feature Highlight --}}
    <section id="features" class="py-32 bg-slate-50 dark:bg-slate-950/50 border-y border-slate-100 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-end mb-20 gap-6">
                <div class="max-w-2xl">
                    <h2 class="text-sm font-black text-indigo-600 uppercase tracking-[0.4em] mb-4">Core Ecosystem</h2>
                    <p class="text-5xl font-black dark:text-white leading-tight">Built for both sides of <span class="text-indigo-600">Learning.</span></p>
                </div>
                <div class="flex -space-x-4 mb-2">
                    <img class="w-14 h-14 rounded-full border-4 border-white dark:border-slate-900" src="https://ui-avatars.com/api/?name=A&background=6366f1&color=fff" alt="">
                    <img class="w-14 h-14 rounded-full border-4 border-white dark:border-slate-900" src="https://ui-avatars.com/api/?name=B&background=a855f7&color=fff" alt="">
                    <img class="w-14 h-14 rounded-full border-4 border-white dark:border-slate-900" src="https://ui-avatars.com/api/?name=C&background=ec4899&color=fff" alt="">
                    <div class="w-14 h-14 rounded-full border-4 border-white dark:border-slate-900 bg-slate-900 flex items-center justify-center text-[10px] font-bold text-white uppercase tracking-tighter">+12k</div>
                </div>
            </div>

            <div class="grid lg:grid-cols-3 gap-10">
                <div class="group p-10 bg-white dark:bg-slate-900 rounded-[40px] border border-slate-100 dark:border-slate-800 hover:border-indigo-500 transition-all hover:shadow-2xl shadow-sm">
                    <div class="w-16 h-16 bg-indigo-50 dark:bg-indigo-500/10 rounded-2xl flex items-center justify-center text-4xl mb-10 group-hover:rotate-12 transition-transform">🎓</div>
                    <h3 class="text-2xl font-black mb-6 dark:text-white">For Students</h3>
                    <ul class="space-y-5">
                        <li class="flex items-center gap-4 text-slate-500 font-medium">
                            <span class="w-6 h-6 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-xs">✓</span>
                            Personalized Paths
                        </li>
                        <li class="flex items-center gap-4 text-slate-500 font-medium">
                            <span class="w-6 h-6 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-xs">✓</span>
                            Smart Assessments
                        </li>
                    </ul>
                </div>

                <div class="group p-10 bg-white dark:bg-slate-900 rounded-[40px] border border-slate-100 dark:border-slate-800 hover:border-purple-500 transition-all hover:shadow-2xl shadow-sm">
                    <div class="w-16 h-16 bg-purple-50 dark:bg-purple-500/10 rounded-2xl flex items-center justify-center text-4xl mb-10 group-hover:rotate-12 transition-transform">👨‍🏫</div>
                    <h3 class="text-2xl font-black mb-6 dark:text-white">For Educators</h3>
                    <ul class="space-y-5">
                        <li class="flex items-center gap-4 text-slate-500 font-medium">
                            <span class="w-6 h-6 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center text-xs">✓</span>
                            Course Builder
                        </li>
                        <li class="flex items-center gap-4 text-slate-500 font-medium">
                            <span class="w-6 h-6 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center text-xs">✓</span>
                            Deep Analytics
                        </li>
                    </ul>
                </div>

                <div class="group p-10 bg-white dark:bg-slate-900 rounded-[40px] border border-slate-100 dark:border-slate-800 hover:border-amber-500 transition-all hover:shadow-2xl shadow-sm">
                    <div class="w-16 h-16 bg-amber-50 dark:bg-amber-500/10 rounded-2xl flex items-center justify-center text-4xl mb-10 group-hover:rotate-12 transition-transform">⚡</div>
                    <h3 class="text-2xl font-black mb-6 dark:text-white">The Tech</h3>
                    <ul class="space-y-5">
                        <li class="flex items-center gap-4 text-slate-500 font-medium">
                            <span class="w-6 h-6 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center text-xs">✓</span>
                            4K Video Streaming
                        </li>
                        <li class="flex items-center gap-4 text-slate-500 font-medium">
                            <span class="w-6 h-6 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center text-xs">✓</span>
                            Cloud Security 2.0
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- Final CTA --}}
    <section class="py-32 px-6">
        <div class="max-w-6xl mx-auto bg-indigo-600 rounded-[56px] p-16 md:p-24 text-center relative overflow-hidden shadow-3xl shadow-indigo-200">
            <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full -mr-32 -mt-32 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-black/10 rounded-full -ml-32 -mb-32 blur-2xl"></div>

            <h2 class="text-5xl md:text-6xl font-black text-white mb-10 relative z-10 leading-tight">
                Ready to redefine your <br> educational limits?
            </h2>
            <div class="flex flex-col sm:flex-row justify-center gap-6 relative z-10">
                <button @click="roleModal = true" class="px-14 py-5 bg-white text-indigo-600 rounded-2xl font-black hover:bg-slate-50 transition-all active:scale-95 text-xl shadow-xl">
                    Get Started Now
                </button>
            </div>
        </div>
    </section>
</main>

<footer class="py-16 border-t border-slate-100 dark:border-slate-800">
    <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-8">
        <div class="flex items-center gap-2 grayscale opacity-50">
            <div class="w-8 h-8 bg-slate-900 dark:bg-white rounded-lg flex items-center justify-center">
                 <svg class="w-5 h-5 text-white dark:text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            </div>
            <span class="text-lg font-black tracking-tighter uppercase">EduLearn</span>
        </div>
        <p class="text-slate-400 text-sm font-medium">© 2026 EduLearn LMS. Crafted for excellence.</p>
        <div class="flex gap-10">
            <a href="#" class="text-xs font-black uppercase tracking-widest text-slate-400 hover:text-indigo-600 transition-colors">Terms</a>
            <a href="#" class="text-xs font-black uppercase tracking-widest text-slate-400 hover:text-indigo-600 transition-colors">Privacy</a>
            <a href="#" class="text-xs font-black uppercase tracking-widest text-slate-400 hover:text-indigo-600 transition-colors">Support</a>
        </div>
    </div>
</footer>

{{-- Role Selection Modal --}}
<div x-show="roleModal"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-[100] flex items-center justify-center p-6 bg-slate-950/60 backdrop-blur-sm" x-cloak>

    <div @click.away="roleModal = false"
         class="bg-white dark:bg-slate-900 w-full max-w-2xl rounded-[40px] p-8 md:p-12 shadow-2xl relative overflow-hidden">

        <button @click="roleModal = false" class="absolute top-8 right-8 text-slate-400 hover:text-slate-600 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        <div class="text-center mb-10">
            <h2 class="text-3xl font-black dark:text-white mb-2">Choose Your Path</h2>
            <p class="text-slate-500 font-medium">How would you like to use EduLearn?</p>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            <a href="{{ route('register', ['role' => 'student']) }}" class="group p-8 bg-slate-50 dark:bg-slate-800 rounded-3xl border-2 border-transparent hover:border-indigo-600 transition-all text-center">
                <div class="text-4xl mb-4 group-hover:scale-110 transition-transform">🎒</div>
                <h3 class="text-xl font-bold dark:text-white mb-2">I am a Student</h3>
                <p class="text-sm text-slate-500">I want to learn skills and earn certificates.</p>
            </a>

            <a href="{{ route('register', ['role' => 'teacher']) }}" class="group p-8 bg-slate-50 dark:bg-slate-800 rounded-3xl border-2 border-transparent hover:border-purple-600 transition-all text-center">
                <div class="text-4xl mb-4 group-hover:scale-110 transition-transform">👨‍🏫</div>
                <h3 class="text-xl font-bold dark:text-white mb-2">I am a Teacher</h3>
                <p class="text-sm text-slate-500">I want to create courses and teach others.</p>
            </a>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
</style>

</body>
</html>
