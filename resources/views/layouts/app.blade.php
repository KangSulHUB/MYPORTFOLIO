<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $profile?->name ?? 'Portfolio' }} - {{ $profile?->translation('title') ?? 'Personal Website' }}</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @php
        $viteManifestExists = file_exists(public_path('build/manifest.json'));
    @endphp

    <!-- Vite Assets -->
    @if ($viteManifestExists)
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', 'Instrument Sans', sans-serif;
            background-color: #030712; /* Slate-950 */
        }
        
        .glass-nav {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .glass-card {
            background: rgba(17, 24, 39, 0.7);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .glass-card:hover {
            border-color: rgba(99, 102, 241, 0.4); /* Indigo-500 */
            box-shadow: 0 10px 30px -10px rgba(99, 102, 241, 0.2);
            transform: translateY(-4px);
        }

        .text-gradient {
            background: linear-gradient(135deg, #a5b4fc 0%, #6366f1 50%, #4f46e5 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .text-gradient-cyan {
            background: linear-gradient(135deg, #67e8f9 0%, #06b6d4 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #030712;
        }
        ::-webkit-scrollbar-thumb {
            background: #1f2937;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #374151;
        }
    </style>
</head>
<body class="text-slate-200 antialiased overflow-x-hidden">

    <!-- Navbar -->
    <nav class="fixed top-0 left-0 right-0 z-50 glass-nav">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="#" class="text-xl font-bold tracking-tight text-white flex items-center gap-2">
                        <span class="w-8 h-8 rounded-lg bg-gradient-to-tr from-indigo-500 to-cyan-500 flex items-center justify-center text-sm font-extrabold text-white">
                            {{ strtoupper(substr($profile?->name ?? 'P', 0, 1)) }}
                        </span>
                        <span>{{ $profile?->name ?? 'Portfolio' }}</span>
                    </a>
                </div>
                
                <!-- Desktop Nav Links -->
                <div class="hidden md:block">
                    <div class="ml-10 flex items-center space-x-8">
                        <a href="#about" class="text-sm font-medium text-slate-300 hover:text-white transition-colors">{{ __('portfolio.about') }}</a>
                        <a href="#experiences" class="text-sm font-medium text-slate-300 hover:text-white transition-colors">{{ __('portfolio.experiences') }}</a>
                        <a href="#awards" class="text-sm font-medium text-slate-300 hover:text-white transition-colors">{{ __('portfolio.awards') }}</a>
                        <a href="#projects" class="text-sm font-medium text-slate-300 hover:text-white transition-colors">{{ __('portfolio.projects') }}</a>
                        <a href="#contact" class="text-sm font-medium text-slate-300 hover:text-white transition-colors">{{ __('portfolio.contact') }}</a>
                        
                        @auth
                            <a href="{{ route('admin.dashboard') }}" class="px-4 h-9 inline-flex items-center text-xs font-semibold rounded-lg bg-indigo-600/30 text-indigo-300 border border-indigo-500/30 hover:bg-indigo-600 hover:text-white transition-all">
                                <i class="fa-solid fa-gauge mr-1.5"></i> Dashboard
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="-mr-2 flex md:hidden">
                    <button type="button" id="mobile-menu-button" class="inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-white hover:bg-slate-800 focus:outline-none">
                        <i class="fa-solid fa-bars text-xl" id="menu-icon-bars"></i>
                        <i class="fa-solid fa-xmark text-xl hidden" id="menu-icon-x"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="hidden md:hidden glass-nav border-t border-slate-800" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="#about" class="block px-3 py-2 rounded-md text-base font-medium text-slate-300 hover:text-white hover:bg-slate-800 transition-colors">{{ __('portfolio.about') }}</a>
                <a href="#experiences" class="block px-3 py-2 rounded-md text-base font-medium text-slate-300 hover:text-white hover:bg-slate-800 transition-colors">{{ __('portfolio.experiences') }}</a>
                <a href="#awards" class="block px-3 py-2 rounded-md text-base font-medium text-slate-300 hover:text-white hover:bg-slate-800 transition-colors">{{ __('portfolio.awards') }}</a>
                <a href="#projects" class="block px-3 py-2 rounded-md text-base font-medium text-slate-300 hover:text-white hover:bg-slate-800 transition-colors">{{ __('portfolio.projects') }}</a>
                <a href="#contact" class="block px-3 py-2 rounded-md text-base font-medium text-slate-300 hover:text-white hover:bg-slate-800 transition-colors">{{ __('portfolio.contact') }}</a>
                
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-indigo-300 hover:bg-indigo-900/30 transition-colors">
                        <i class="fa-solid fa-gauge mr-1.5"></i> Admin Dashboard
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-16">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="border-t border-slate-900 bg-slate-950 py-12 mt-20">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <p class="text-sm text-slate-500">
                        &copy; {{ date('Y') }} {{ $profile?->name ?? 'Portfolio' }}. {{ __('portfolio.all_rights_reserved') }}
                    </p>
                </div>
                <div class="flex items-center space-x-6">
                    @if($profile?->github_url ?? false)
                        <a href="{{ $profile->github_url }}" target="_blank" class="text-slate-400 hover:text-white transition-colors text-lg">
                            <i class="fa-brands fa-github"></i>
                        </a>
                    @endif
                    @if($profile?->linkedin_url ?? false)
                        <a href="{{ $profile->linkedin_url }}" target="_blank" class="text-slate-400 hover:text-white transition-colors text-lg">
                            <i class="fa-brands fa-linkedin"></i>
                        </a>
                    @endif
                    @if($profile?->email ?? false)
                        <a href="mailto:{{ $profile->email }}" class="text-slate-400 hover:text-white transition-colors text-lg">
                            <i class="fa-regular fa-envelope"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </footer>

    @if (! $viteManifestExists)
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const btn = document.getElementById('mobile-menu-button');
                const menu = document.getElementById('mobile-menu');
                const barsIcon = document.getElementById('menu-icon-bars');
                const xIcon = document.getElementById('menu-icon-x');

                if (!btn || !menu || !barsIcon || !xIcon) {
                    return;
                }

                btn.addEventListener('click', () => {
                    menu.classList.toggle('hidden');
                    barsIcon.classList.toggle('hidden');
                    xIcon.classList.toggle('hidden');
                });
            });
        </script>
    @endif

    @yield('scripts')
</body>
</html>
