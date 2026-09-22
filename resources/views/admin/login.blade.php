<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Portfolio Admin</title>
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
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
            background-color: #030712; /* Slate-950 */
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4 antialiased text-slate-200">

    <div class="w-full max-w-md bg-slate-900 border border-slate-800 rounded-3xl p-8 relative overflow-hidden shadow-2xl">
        <!-- Decorative Glow -->
        <div class="absolute -top-20 -right-20 w-44 h-44 bg-indigo-500/10 rounded-full blur-2xl"></div>
        <div class="absolute -bottom-20 -left-20 w-44 h-44 bg-cyan-500/10 rounded-full blur-2xl"></div>

        <div class="text-center mb-8 relative">
            <span class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-indigo-500 to-cyan-500 flex items-center justify-center text-xl font-extrabold text-white mx-auto mb-4">
                P
            </span>
            <h1 class="text-2xl font-bold text-white tracking-tight">Login Portfolio Admin</h1>
            <p class="text-slate-400 text-xs mt-1">Masuk untuk mengelola proyek dan bio Anda</p>
        </div>

        <form action="{{ route('login') }}" method="POST" class="space-y-5 relative">
            @csrf

            @if ($errors->has('login'))
                <div class="rounded-xl border border-rose-500/30 bg-rose-500/10 px-4 py-3 text-sm font-semibold text-rose-200">
                    <i class="fa-solid fa-circle-exclamation mr-2 text-rose-400"></i>
                    {{ $errors->first('login') }}
                </div>
            @endif

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Alamat Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                       class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-slate-200 placeholder-slate-600 focus:outline-none focus:border-indigo-500 text-sm transition-colors">
                @error('email')
                    <span class="text-xs text-rose-500 font-semibold mt-1.5 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Kata Sandi</label>
                <input type="password" name="password" id="password" required
                       class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-slate-200 placeholder-slate-600 focus:outline-none focus:border-indigo-500 text-sm transition-colors">
                @error('password')
                    <span class="text-xs text-rose-500 font-semibold mt-1.5 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input type="checkbox" name="remember" id="remember" 
                       class="w-4 h-4 rounded bg-slate-950 border border-slate-800 text-indigo-600 focus:ring-indigo-500 focus:ring-offset-slate-900 focus:ring-2">
                <label for="remember" class="ml-2 text-xs font-semibold text-slate-400 cursor-pointer">Ingat Saya</label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full py-3.5 px-4 font-semibold text-sm rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white transition-all shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/30">
                Masuk
            </button>
        </form>
    </div>

</body>
</html>
