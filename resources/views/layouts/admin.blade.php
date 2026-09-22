<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Portfolio</title>
    
    <!-- Fonts and Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
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
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc; /* Slate-50 */
        }
    </style>
</head>
<body class="text-slate-800 antialiased">

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-slate-900 text-slate-300 flex-shrink-0 flex flex-col hidden md:flex border-r border-slate-800">
            <!-- Sidebar Header -->
            <div class="h-16 flex items-center px-6 border-b border-slate-800">
                <a href="{{ route('home') }}" target="_blank" class="text-lg font-bold text-white flex items-center gap-2 hover:text-indigo-400 transition-colors">
                    <i class="fa-solid fa-laptop-code text-indigo-500"></i>
                    <span>Portfolio Admin</span>
                </a>
            </div>
            
            <!-- Navigation Links -->
            <nav class="flex-1 px-4 py-6 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ Route::is('admin.dashboard') ? 'bg-indigo-600 text-white' : 'hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-gauge mr-3 w-5 text-center"></i> Dashboard
                </a>
                
                <a href="{{ route('admin.projects.index') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ Route::is('admin.projects.*') ? 'bg-indigo-600 text-white' : 'hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-diagram-project mr-3 w-5 text-center"></i> Kelola Proyek
                </a>
                
                <a href="{{ route('admin.experiences.index') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ Route::is('admin.experiences.*') ? 'bg-indigo-600 text-white' : 'hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-graduation-cap mr-3 w-5 text-center"></i> Kelola Pengalaman
                </a>

                <a href="{{ route('admin.awards.index') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ Route::is('admin.awards.*') ? 'bg-indigo-600 text-white' : 'hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-trophy mr-3 w-5 text-center"></i> Kelola Penghargaan
                </a>
                
                <a href="{{ route('admin.profile.edit') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ Route::is('admin.profile.*') ? 'bg-indigo-600 text-white' : 'hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-user-gear mr-3 w-5 text-center"></i> Pengaturan Profil
                </a>
                <a href="{{ route('admin.settings.language.edit') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ Route::is('admin.settings.language.*') ? 'bg-indigo-600 text-white' : 'hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-language mr-3 w-5 text-center"></i> Bahasa Portfolio
                </a>
            </nav>
            
            <!-- Sidebar Footer / Logout -->
            <div class="p-4 border-t border-slate-800">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-4 py-2.5 rounded-lg text-sm font-medium text-rose-400 hover:bg-rose-950/20 hover:text-rose-300 transition-colors">
                        <i class="fa-solid fa-right-from-bracket mr-3 w-5 text-center"></i> Keluar (Logout)
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-h-screen overflow-x-hidden">
            <!-- Topbar (Mobile Menu Toggle & Title) -->
            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6">
                <div class="flex items-center">
                    <button type="button" id="mobile-sidebar-toggle" class="p-2 rounded-lg text-slate-500 hover:bg-slate-100 md:hidden">
                        <i class="fa-solid fa-bars text-lg"></i>
                    </button>
                    <h1 class="text-lg font-bold text-slate-800 ml-2 md:ml-0">
                        @yield('header_title', 'Admin Panel')
                    </h1>
                </div>
                
                <!-- Quick Link to website -->
                <div>
                    <a href="{{ route('home') }}" target="_blank" class="px-3.5 py-1.5 inline-flex items-center text-xs font-semibold rounded-lg bg-slate-100 text-slate-600 hover:bg-slate-200 transition-all">
                        <i class="fa-solid fa-arrow-up-right-from-square mr-1.5"></i> Lihat Website
                    </a>
                </div>
            </header>

            <!-- Mobile Drawer Menu (Hidden by default) -->
            <div id="mobile-sidebar-drawer" class="fixed inset-0 z-40 hidden">
                <div class="fixed inset-0 bg-slate-900/60 backdrop-filter backdrop-blur-sm" onclick="toggleMobileSidebar()"></div>
                <div class="fixed inset-y-0 left-0 w-64 bg-slate-900 text-slate-300 flex flex-col z-50">
                    <div class="h-16 flex items-center justify-between px-6 border-b border-slate-800">
                        <span class="font-bold text-white">Portfolio Admin</span>
                        <button type="button" onclick="toggleMobileSidebar()" class="text-slate-400 hover:text-white">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>
                    <nav class="flex-1 px-4 py-6 space-y-1">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ Route::is('admin.dashboard') ? 'bg-indigo-600 text-white' : 'hover:bg-slate-800' }}">
                            <i class="fa-solid fa-gauge mr-3 w-5 text-center"></i> Dashboard
                        </a>
                        <a href="{{ route('admin.projects.index') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ Route::is('admin.projects.*') ? 'bg-indigo-600 text-white' : 'hover:bg-slate-800' }}">
                            <i class="fa-solid fa-diagram-project mr-3 w-5 text-center"></i> Kelola Proyek
                        </a>
                        <a href="{{ route('admin.experiences.index') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ Route::is('admin.experiences.*') ? 'bg-indigo-600 text-white' : 'hover:bg-slate-800' }}">
                            <i class="fa-solid fa-graduation-cap mr-3 w-5 text-center"></i> Kelola Pengalaman
                        </a>
                        <a href="{{ route('admin.awards.index') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ Route::is('admin.awards.*') ? 'bg-indigo-600 text-white' : 'hover:bg-slate-800' }}">
                            <i class="fa-solid fa-trophy mr-3 w-5 text-center"></i> Kelola Penghargaan
                        </a>
                        <a href="{{ route('admin.profile.edit') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ Route::is('admin.profile.*') ? 'bg-indigo-600 text-white' : 'hover:bg-slate-800' }}">
                            <i class="fa-solid fa-user-gear mr-3 w-5 text-center"></i> Pengaturan Profil
                        </a>
                        <a href="{{ route('admin.settings.language.edit') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ Route::is('admin.settings.language.*') ? 'bg-indigo-600 text-white' : 'hover:bg-slate-800' }}">
                            <i class="fa-solid fa-language mr-3 w-5 text-center"></i> Bahasa Portfolio
                        </a>
                    </nav>
                    <div class="p-4 border-t border-slate-800">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full flex items-center px-4 py-2.5 rounded-lg text-sm font-medium text-rose-400 hover:bg-rose-950/20 transition-colors">
                                <i class="fa-solid fa-right-from-bracket mr-3 w-5 text-center"></i> Keluar (Logout)
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <main class="flex-1 w-full p-6 md:p-8 xl:p-10">
                <!-- Notifications -->
                @if(session('success'))
                    <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center gap-3">
                        <i class="fa-solid fa-circle-check text-emerald-500 text-lg"></i>
                        <span class="text-sm font-semibold">{{ session('success') }}</span>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 flex items-center gap-3">
                        <i class="fa-solid fa-circle-xmark text-rose-500 text-lg"></i>
                        <span class="text-sm font-semibold">{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Script for mobile menu -->
    <script>
        const drawer = document.getElementById('mobile-sidebar-drawer');
        const toggleBtn = document.getElementById('mobile-sidebar-toggle');

        toggleBtn.addEventListener('click', () => {
            drawer.classList.remove('hidden');
        });

        function toggleMobileSidebar() {
            drawer.classList.add('hidden');
        }
    </script>
    
    @yield('scripts')
</body>
</html>
