@extends('layouts.app')

@section('content')
<style>
    .skill-orbit-card {
        position: relative;
        isolation: isolate;
        transform-style: preserve-3d;
        transition: transform 260ms ease, border-color 260ms ease, box-shadow 260ms ease, background 260ms ease;
        animation: skillFloat 5s ease-in-out infinite;
    }

    .skill-orbit-card:nth-child(2) {
        animation-delay: 0.35s;
    }

    .skill-orbit-card:nth-child(3) {
        animation-delay: 0.7s;
    }

    .skill-orbit-card::before {
        content: '';
        position: absolute;
        inset: -1px;
        z-index: -1;
        border-radius: 1rem;
        background: radial-gradient(circle at var(--skill-x, 50%) var(--skill-y, 50%), rgba(255, 255, 255, 0.16), transparent 34%);
        opacity: 0;
        transition: opacity 260ms ease;
    }

    .skill-orbit-card:hover,
    .skill-orbit-card:focus-within {
        border-color: rgba(125, 211, 252, 0.45);
        box-shadow: 0 18px 40px -24px var(--skill-glow, rgba(99, 102, 241, 0.85));
        transform: perspective(900px) rotateX(var(--skill-rotate-x, 0deg)) rotateY(var(--skill-rotate-y, 0deg)) translateY(-6px);
    }

    .skill-orbit-card:hover::before,
    .skill-orbit-card:focus-within::before {
        opacity: 1;
    }

    .skill-logo-wrap {
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.12), 0 16px 28px -22px var(--skill-glow, rgba(99, 102, 241, 0.85));
    }

    .skill-orbit-card:hover .skill-logo-wrap {
        transform: translateZ(24px) scale(1.06);
    }

    .skill-orbit-card:hover .skill-logo {
        animation: skillPulse 900ms ease-in-out;
    }

    @keyframes skillFloat {
        0%, 100% {
            translate: 0 0;
        }

        50% {
            translate: 0 -6px;
        }
    }

    @keyframes skillPulse {
        0%, 100% {
            transform: scale(1);
        }

        45% {
            transform: scale(1.16) rotate(-4deg);
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .skill-orbit-card,
        .skill-orbit-card:hover .skill-logo {
            animation: none;
        }

        .skill-orbit-card,
        .skill-orbit-card:hover,
        .skill-logo-wrap {
            transition: none;
            transform: none;
        }
    }
</style>

<div class="relative overflow-hidden">
    <!-- Decorative background elements -->
    <div class="absolute top-1/4 left-1/10 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl -z-10"></div>
    <div class="absolute top-1/2 right-1/10 w-80 h-80 bg-cyan-500/10 rounded-full blur-3xl -z-10"></div>

    <!-- 1. Hero Section -->
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-32 flex flex-col md:flex-row items-center justify-between gap-12">
        <div class="flex-1 space-y-6 text-center md:text-left">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-900 border border-slate-800 text-xs font-semibold text-indigo-300">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                {{ __('portfolio.available') }}
            </div>
            
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold tracking-tight text-white leading-tight">
                {{ __('portfolio.hello') }} <span class="text-gradient font-extrabold">{{ $profile?->name ?? 'Nama Anda' }}</span>
            </h1>
            
            <h2 class="text-xl sm:text-2xl font-bold text-indigo-300">
                {{ $profile?->translation('title') ?? 'Data Analyst & Engineer' }}
            </h2>
            
            <p class="text-slate-400 max-w-xl mx-auto md:mx-0 text-base sm:text-lg leading-relaxed">
                {{ $profile?->translation('bio') ?? '' }}
            </p>
            
            <div class="flex flex-wrap items-center justify-center md:justify-start gap-4">
                <a href="#projects" class="px-6 py-3 font-semibold text-sm rounded-xl bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/30 transition-all duration-300">
                    <i class="fa-solid fa-briefcase mr-2"></i> {{ __('portfolio.view_projects') }}
                </a>
                
                @if(!empty($profile?->resume_path))
                    <a href="{{ asset('storage/' . $profile->resume_path) }}" target="_blank" class="px-6 py-3 font-semibold text-sm rounded-xl bg-slate-900 border border-slate-800 hover:bg-slate-800 text-white transition-all">
                        <i class="fa-solid fa-download mr-2"></i> {{ __('portfolio.download_cv') }}
                    </a>
                @endif
            </div>

            <!-- Social links -->
            <div class="flex items-center justify-center md:justify-start gap-5 pt-4 text-slate-400">
                @if(!empty($profile?->github_url))
                    <a href="{{ $profile->github_url }}" target="_blank" class="hover:text-white transition-colors text-xl">
                        <i class="fa-brands fa-github"></i>
                    </a>
                @endif
                @if(!empty($profile?->linkedin_url))
                    <a href="{{ $profile->linkedin_url }}" target="_blank" class="hover:text-white transition-colors text-xl">
                        <i class="fa-brands fa-linkedin"></i>
                    </a>
                @endif
                @if(!empty($profile?->email))
                    <a href="mailto:{{ $profile->email }}" class="hover:text-white transition-colors text-xl">
                        <i class="fa-regular fa-envelope"></i>
                    </a>
                @endif
            </div>
        </div>

        <!-- Hero Photo -->
        <div class="flex-shrink-0 relative w-64 h-64 sm:w-80 sm:h-80 mx-auto">
            <div class="absolute inset-0 bg-gradient-to-tr from-indigo-500 to-cyan-500 rounded-2xl transform rotate-3 blur-md opacity-30"></div>
            <div class="relative w-full h-full rounded-2xl overflow-hidden border border-slate-800 bg-slate-900 flex items-center justify-center">
                @if(!empty($profile?->photo_path))
                    <img src="{{ asset('storage/' . $profile->photo_path) }}" alt="{{ $profile?->name ?? 'Profil' }}" class="w-full h-full object-cover" loading="lazy" decoding="async">
                @else
                    <!-- Fallback SVG Avatar -->
                    <div class="w-full h-full flex flex-col items-center justify-center bg-slate-900/50 p-6">
                        <i class="fa-solid fa-user-tie text-8xl text-indigo-500/40 mb-3"></i>
                        <span class="text-xs text-slate-500">Upload your photo in the admin panel</span>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- 2. About & Skills Section -->
    <section id="about" class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-20 border-t border-slate-900">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            <div class="md:col-span-1">
                <h2 class="text-3xl font-extrabold text-white tracking-tight">{{ __('portfolio.skills_title') }}</h2>
                <div class="w-12 h-1 bg-gradient-to-r from-indigo-500 to-cyan-500 rounded mt-3"></div>
                <p class="text-slate-400 mt-4 text-sm leading-relaxed">
                    {{ __('portfolio.skills_intro') }}
                </p>
            </div>
            
            <div class="md:col-span-2">
                @php
                    $skills = collect($profile?->skills ?? [])
                        ->unique(fn ($skill) => strtolower(trim($skill)))
                        ->values();
                    $featuredSkills = [
                        'python' => [
                            'label' => 'Python',
                            'icon' => 'fa-brands fa-python',
                            'summary' => 'Pandas, NumPy, Matplotlib, scikit-learn, analytics',
                            'color' => '#facc15',
                            'glow' => 'rgba(250, 204, 21, 0.75)',
                            'gradient' => 'from-yellow-400/20 via-sky-400/10 to-slate-950',
                        ],
                        'sql' => [
                            'label' => 'SQL',
                            'icon' => 'fa-solid fa-database',
                            'summary' => 'Queries, joins, aggregation, data reporting',
                            'color' => '#38bdf8',
                            'glow' => 'rgba(56, 189, 248, 0.75)',
                            'gradient' => 'from-sky-400/20 via-cyan-400/10 to-slate-950',
                        ],
                        'laravel' => [
                            'label' => 'Laravel',
                            'icon' => 'fa-brands fa-laravel',
                            'summary' => 'Fullstack apps, Blade, backend, dashboards',
                            'color' => '#fb7185',
                            'glow' => 'rgba(251, 113, 133, 0.75)',
                            'gradient' => 'from-rose-400/20 via-red-500/10 to-slate-950',
                        ],
                        'r studio' => [
                            'label' => 'R Studio',
                            'icon' => 'fa-brands fa-r-project',
                            'summary' => 'Statistics, visualization, analysis',
                            'color' => '#60a5fa',
                            'glow' => 'rgba(96, 165, 250, 0.75)',
                            'gradient' => 'from-blue-400/20 via-cyan-400/10 to-slate-950',
                        ],
                        'excel' => [
                            'label' => 'Excel',
                            'icon' => 'fa-solid fa-file-excel',
                            'summary' => 'Formulas, lookup, pivot tables, reporting',
                            'color' => '#34d399',
                            'glow' => 'rgba(52, 211, 153, 0.75)',
                            'gradient' => 'from-emerald-400/20 via-green-400/10 to-slate-950',
                        ],
                        'word' => [
                            'label' => 'Word',
                            'icon' => 'fa-solid fa-file-word',
                            'summary' => 'Documents, reports, formatting, and collaboration',
                            'color' => '#60a5fa',
                            'glow' => 'rgba(96, 165, 250, 0.75)',
                            'gradient' => 'from-blue-400/20 via-sky-400/10 to-slate-950',
                        ],
                        'tableau' => [
                            'label' => 'Tableau',
                            'icon' => 'fa-solid fa-chart-pie',
                            'summary' => 'Dashboards, visualization, business insights',
                            'color' => '#fb923c',
                            'glow' => 'rgba(251, 146, 60, 0.75)',
                            'gradient' => 'from-orange-400/20 via-amber-400/10 to-slate-950',
                        ],
                    ];

                    $featuredSkillNames = $skills
                        ->filter(fn ($skill) => array_key_exists(strtolower(trim($skill)), $featuredSkills))
                        ->values();

                    $otherSkills = $skills
                        ->reject(fn ($skill) => array_key_exists(strtolower(trim($skill)), $featuredSkills))
                        ->values();
                @endphp

                @if($featuredSkillNames->isNotEmpty())
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
                        @foreach($featuredSkillNames as $skill)
                            @php
                                $skillKey = strtolower(trim($skill));
                                $skillMeta = $featuredSkills[$skillKey];
                            @endphp

                            <div class="skill-orbit-card group min-h-40 rounded-2xl border border-slate-800/90 bg-gradient-to-br {{ $skillMeta['gradient'] }} p-4 overflow-hidden"
                                style="--skill-glow: {{ $skillMeta['glow'] }};"
                                tabindex="0"
                                aria-label="{{ $skillMeta['label'] }} skill">
                                <div class="absolute -right-6 -top-6 w-24 h-24 rounded-full bg-white/5 blur-2xl"></div>
                                <div class="relative flex h-full flex-col justify-between gap-5">
                                    <div class="skill-logo-wrap grid h-16 w-16 place-items-center rounded-2xl border border-white/10 bg-slate-950/75 transition-transform duration-300">
                                        <i class="{{ $skillMeta['icon'] }} skill-logo text-4xl" style="color: {{ $skillMeta['color'] }};"></i>
                                    </div>

                                    <div>
                                        <h3 class="text-lg font-extrabold text-white">{{ $skillMeta['label'] }}</h3>
                                        <p class="mt-1 text-xs leading-relaxed text-slate-400">{{ $skillMeta['summary'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="flex flex-wrap gap-3 {{ $featuredSkillNames->isNotEmpty() && $otherSkills->isNotEmpty() ? 'mt-5' : '' }}">
                    @if(!empty($profile?->skills))
                        @foreach($otherSkills as $skill)
                            <div class="px-4 py-2.5 rounded-xl bg-slate-900/80 border border-slate-800/80 text-sm font-semibold text-slate-300 flex items-center gap-2 hover:border-indigo-500/30 transition-all">
                                <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                                {{ $skill }}
                            </div>
                        @endforeach
                        @if($otherSkills->isEmpty() && $featuredSkillNames->isNotEmpty())
                            <span class="sr-only">Featured skills are shown above.</span>
                        @endif
                    @else
                        <div class="text-slate-500 text-sm">Tambahkan beberapa keahlian (skills) di halaman Admin Panel.</div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- 3. Experiences Section (Timeline) -->
    <section id="experiences" class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-20 border-t border-slate-900">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-extrabold text-white tracking-tight">{{ __('portfolio.experience_title') }}</h2>
            <div class="w-16 h-1 bg-gradient-to-r from-indigo-500 to-cyan-500 rounded mx-auto mt-3"></div>
            <p class="text-slate-400 mt-4 text-sm max-w-md mx-auto">
                {{ __('portfolio.experience_intro') }}
            </p>
        </div>

        @if(count($experiences) > 0)
            <div class="relative border-l border-slate-800 max-w-3xl mx-auto pl-6 sm:pl-8 space-y-12">
                @foreach($experiences as $exp)
                    <div class="relative">
                        <!-- Timeline circle icon -->
                        <span class="absolute -left-10 sm:-left-12 top-1.5 flex items-center justify-center w-8 h-8 rounded-full ring-8 ring-slate-950 bg-slate-900 border border-slate-800 text-xs">
                            @if($exp->type == 'education')
                                <i class="fa-solid fa-graduation-cap text-indigo-400"></i>
                            @else
                                <i class="fa-solid fa-briefcase text-cyan-400"></i>
                            @endif
                        </span>
                        
                        <div class="flex flex-wrap items-center justify-between gap-2 mb-1">
                            <h3 class="text-lg font-bold text-white leading-snug">{{ $exp->translation('title') }}</h3>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-900 border border-slate-800 text-slate-400">
                                {{ $exp->start_date->format('M Y') }} - 
                                @if($exp->is_current)
                                    {{ __('portfolio.present') }}
                                @else
                                    {{ $exp->end_date ? $exp->end_date->format('M Y') : '' }}
                                @endif
                            </span>
                        </div>
                        
                        <h4 class="text-sm font-semibold text-slate-400 mb-3">{{ $exp->company_or_institution }}</h4>
                        
                        @if($exp->description)
                            <div class="text-slate-400 text-sm leading-relaxed whitespace-pre-line bg-slate-900/35 border border-slate-900/50 rounded-xl p-4">
                                {{ $exp->translation('description') }}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12 text-slate-500">
                <i class="fa-regular fa-clock text-4xl mb-3 block"></i>
                <p class="text-sm">{{ __('portfolio.no_experiences') }}</p>
            </div>
        @endif
    </section>

    <!-- 4. Awards Section -->
    <section id="awards" class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-20 border-t border-slate-900">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-extrabold text-white tracking-tight">{{ __('portfolio.awards_title') }}</h2>
            <div class="w-16 h-1 bg-gradient-to-r from-indigo-500 to-cyan-500 rounded mx-auto mt-3"></div>
            <p class="text-slate-400 mt-4 text-sm max-w-md mx-auto">
                {{ __('portfolio.awards_intro') }}
            </p>
        </div>

        @if($awards->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($awards as $award)
                    <div class="glass-card rounded-2xl overflow-hidden flex flex-col h-full">
                        <div class="relative aspect-[4/3] w-full overflow-hidden bg-slate-900 border-b border-slate-800">
                            @if($award->image_path)
                                <img src="{{ asset('storage/' . $award->image_path) }}" alt="{{ $award->translation('title') }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-tr from-slate-900 to-slate-950">
                                    <i class="fa-solid fa-trophy text-5xl text-amber-400/25 mb-3"></i>
                                    <span class="text-xs text-slate-500">No preview image</span>
                                </div>
                            @endif

                            @if($award->is_featured)
                                <div class="absolute top-3 left-3 px-2.5 py-0.5 rounded-md bg-amber-500/15 border border-amber-400/25 text-[10px] font-bold text-amber-200 uppercase tracking-wider">
                                    {{ __('portfolio.featured') }}
                                </div>
                            @endif
                        </div>

                        <div class="p-6 flex flex-col flex-grow space-y-4">
                            <div class="space-y-1">
                                <h3 class="text-lg font-bold text-white leading-snug">{{ $award->translation('title') }}</h3>
                                <p class="text-xs text-slate-500">
                                    {{ $award->issuer ?: 'Award' }}
                                    @if($award->award_date)
                                        <span class="mx-1">&middot;</span>{{ $award->award_date->format('M Y') }}
                                    @endif
                                </p>
                            </div>

                            @if($award->description)
                                <p class="text-slate-400 text-sm leading-relaxed line-clamp-3 flex-grow">
                                    {{ $award->translation('description') }}
                                </p>
                            @endif

                            @if($award->certificate_path || $award->external_url)
                                <div class="flex flex-wrap items-center gap-3 pt-3 border-t border-slate-900 mt-auto">
                                    @if($award->certificate_path)
                                        <a href="{{ asset('storage/' . $award->certificate_path) }}" target="_blank" class="text-xs font-semibold text-amber-300 hover:text-amber-200 flex items-center gap-1.5">
                                            <i class="fa-solid fa-file-lines"></i> View Certificate
                                        </a>
                                    @endif

                                    @if($award->external_url)
                                        <a href="{{ $award->external_url }}" target="_blank" class="text-xs font-semibold text-indigo-300 hover:text-indigo-200 flex items-center gap-1.5">
                                            <i class="fa-solid fa-arrow-up-right-from-square"></i> Verify
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16 text-slate-500">
                <i class="fa-solid fa-award text-5xl mb-3 block"></i>
                <p class="text-sm">{{ __('portfolio.no_awards') }}</p>
            </div>
        @endif
    </section>

    <!-- 5. Projects Section -->
    <section id="projects" class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-20 border-t border-slate-900">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-extrabold text-white tracking-tight">{{ __('portfolio.projects_title') }}</h2>
            <div class="w-16 h-1 bg-gradient-to-r from-indigo-500 to-cyan-500 rounded mx-auto mt-3"></div>
            <p class="text-slate-400 mt-4 text-sm max-w-md mx-auto">
                {{ __('portfolio.projects_intro') }}
            </p>
        </div>

        @if(count($projects) > 0)
            <!-- Category Filter -->
            @php
                $categories = $projects->map(fn ($project) => $project->translation('category'))->unique();
            @endphp
            <div class="flex flex-wrap items-center justify-center gap-2 mb-10">
                <button type="button" data-filter="all" class="filter-btn px-4 py-2 text-xs sm:text-sm font-semibold rounded-lg bg-indigo-600 text-white border border-indigo-600 transition-all">
                    {{ __('portfolio.all') }}
                </button>
                @foreach($categories as $cat)
                    <button type="button" data-filter="{{ Str::slug($cat) }}" class="filter-btn px-4 py-2 text-xs sm:text-sm font-semibold rounded-lg bg-slate-900 text-slate-400 border border-slate-800 hover:text-white hover:border-slate-700 transition-all">
                        {{ $cat }}
                    </button>
                @endforeach
            </div>

            <!-- Projects Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="projects-grid">
                @foreach($projects as $project)
                    <div class="project-card glass-card rounded-2xl overflow-hidden flex flex-col h-full" data-category="{{ Str::slug($project->translation('category')) }}">
                        <!-- Project Image Preview -->
                        <div class="relative aspect-video w-full overflow-hidden bg-slate-900 border-b border-slate-800">
                            @if($project->image_path)
                                <img src="{{ asset('storage/' . $project->image_path) }}" alt="{{ $project->translation('title') }}" class="w-full h-full object-cover">
                            @elseif($project->video_path || $project->video_url)
                                <div class="w-full h-full flex flex-col items-center justify-center text-slate-600 bg-gradient-to-tr from-slate-900 to-slate-950">
                                    <i class="fa-solid fa-play-circle text-4xl text-indigo-500/20 mb-2"></i>
                                    <span class="text-xs text-slate-500">Video / Demo available</span>
                                </div>
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-slate-600 bg-gradient-to-tr from-slate-900 to-slate-950">
                                    <i class="fa-solid fa-code text-4xl text-indigo-500/20 mb-2"></i>
                                    <span class="text-xs text-slate-500">No image available</span>
                                </div>
                            @endif
                            <div class="absolute top-3 left-3 px-2.5 py-0.5 rounded-md bg-slate-950/80 border border-slate-800 text-[10px] font-bold text-indigo-300 uppercase tracking-wider">
                                {{ $project->translation('category') }}
                            </div>
                            @if(!empty($project->attachments))
                                <div class="absolute top-3 right-3 px-2.5 py-0.5 rounded-md bg-slate-950/80 border border-slate-800 text-[10px] font-semibold text-slate-300">
                                    {{ count($project->attachments) }} file
                                </div>
                            @endif
                        </div>

                        <!-- Card Body -->
                        <div class="p-6 flex flex-col flex-grow space-y-4">
                            <div class="space-y-1">
                                <h3 class="text-lg font-bold text-white line-clamp-1 hover:text-indigo-400 transition-colors cursor-pointer" data-project-id="{{ $project->id }}">
                                    {{ $project->translation('title') }}
                                </h3>
                                <p class="text-xs text-slate-500">
                                    Created: {{ $project->created_at->format('M Y') }}
                                </p>
                            </div>
                            
                            <p class="text-slate-400 text-sm leading-relaxed line-clamp-3 flex-grow">
                                {{ strip_tags($project->translation('description')) }}
                            </p>

                            <!-- Tags -->
                            @if(is_array($project->tags) && count($project->tags) > 0)
                                <div class="flex flex-wrap gap-1.5 pt-2">
                                    @foreach($project->tags as $tag)
                                        <span class="px-2 py-0.5 rounded bg-slate-900 text-[10px] font-medium text-slate-400 border border-slate-800">
                                            {{ $tag }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Action buttons -->
                            <div class="flex items-center justify-between gap-4 pt-3 border-t border-slate-900 mt-auto">
                                <button type="button" data-project-id="{{ $project->id }}" class="text-xs font-semibold text-indigo-400 hover:text-indigo-300 flex items-center gap-1.5">
                                    <i class="fa-solid fa-circle-info"></i> {{ __('portfolio.details') }}
                                </button>
                                
                                <div class="flex items-center gap-3">
                                    @if($project->github_url)
                                        <a href="{{ $project->github_url }}" target="_blank" class="text-slate-400 hover:text-white transition-colors text-sm" title="Lihat di GitHub">
                                            <i class="fa-brands fa-github"></i>
                                        </a>
                                    @endif
                                    @if($project->demo_url)
                                        <a href="{{ $project->demo_url }}" target="_blank" class="text-slate-400 hover:text-white transition-colors text-sm" title="Lihat Demo">
                                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16 text-slate-500">
                <i class="fa-solid fa-laptop-code text-5xl mb-3 block"></i>
                <p class="text-sm">{{ __('portfolio.no_projects') }}</p>
            </div>
        @endif
    </section>

    <!-- 6. Contact Section -->
    <section id="contact" class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-20 border-t border-slate-900">
        <div class="glass-card rounded-3xl p-8 md:p-12 text-center relative overflow-hidden">
            <div class="absolute -top-12 -left-12 w-24 h-24 bg-indigo-500/10 rounded-full blur-xl"></div>
            
            <h2 class="text-3xl font-extrabold text-white tracking-tight">{{ __('portfolio.contact_title') }}</h2>
            <p class="text-slate-400 mt-4 text-base max-w-lg mx-auto">
                {{ __('portfolio.contact_intro') }}
            </p>
            
            <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
                @if(!empty($profile?->email))
                    <button type="button" data-copy-email="{{ $profile->email }}" class="px-8 py-3.5 font-semibold text-sm rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white shadow-lg shadow-indigo-500/20 transition-all flex items-center justify-center gap-2 w-full sm:w-auto">
                        <i class="fa-regular fa-envelope"></i>
                        <span data-copy-email-label>{{ __('portfolio.email_me') }}</span>
                    </button>
                @endif
                
                @if(!empty($profile?->linkedin_url))
                    <a href="{{ $profile->linkedin_url }}" target="_blank" class="px-8 py-3.5 font-semibold text-sm rounded-xl bg-slate-900 border border-slate-800 hover:bg-slate-800 text-white transition-all flex items-center justify-center gap-2 w-full sm:w-auto">
                        <i class="fa-brands fa-linkedin text-indigo-400"></i> {{ __('portfolio.connect_linkedin') }}
                    </a>
                @endif
            </div>
        </div>
    </section>
</div>

<!-- Project Details Modal -->
<div id="project-modal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Overlay background -->
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-slate-950/80 backdrop-filter backdrop-blur-sm" data-modal-backdrop></div>
        
        <!-- Trick to center modal in tailwind -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
        <!-- Modal Card -->
        <div class="relative inline-block align-bottom bg-slate-900 border border-slate-800 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
            <div class="absolute top-4 right-4 z-10">
                <button type="button" id="modal-close-button" class="w-8 h-8 rounded-full bg-slate-950 border border-slate-800 text-slate-400 hover:text-white flex items-center justify-center transition-colors focus:outline-none">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Modal Content (Dynamically Populated) -->
            <div class="flex flex-col">
                <div class="aspect-video w-full bg-slate-950 relative overflow-hidden" id="modal-image-container">
                    <img id="modal-image" src="" alt="Project" class="w-full h-full object-cover">
                </div>
                
                <div class="p-6 md:p-8 space-y-5">
                    <div class="space-y-1">
                        <div class="inline-flex px-2.5 py-0.5 rounded-md bg-indigo-500/10 border border-indigo-500/20 text-[10px] font-bold text-indigo-300 uppercase tracking-wider" id="modal-category">
                            Category
                        </div>
                        <h3 class="text-2xl font-extrabold text-white" id="modal-title-text">
                            Project Title
                        </h3>
                    </div>

                    <!-- Description -->
                    <div class="text-slate-300 text-sm leading-relaxed whitespace-pre-wrap max-h-60 overflow-y-auto pr-2" id="modal-description">
                        Full project description.
                    </div>

                    <div id="modal-media-info" class="space-y-3"></div>

                    <!-- Tags -->
                    <div class="space-y-2">
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Technologies Used</h4>
                        <div class="flex flex-wrap gap-1.5" id="modal-tags">
                            <!-- Tags injected here -->
                        </div>
                    </div>

                    <!-- Modal Actions -->
                    <div class="flex flex-wrap items-center justify-between gap-4 pt-4 border-t border-slate-800">
                        <div class="flex items-center gap-3">
                            <a id="modal-github" href="" target="_blank" class="px-4 py-2 rounded-lg bg-slate-950 border border-slate-800 hover:bg-slate-800 text-white text-xs font-semibold flex items-center gap-2 transition-all">
                                <i class="fa-brands fa-github"></i> GitHub Repository
                            </a>
                            <a id="modal-demo" href="" target="_blank" class="px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold flex items-center gap-2 transition-all">
                                <i class="fa-solid fa-arrow-up-right-from-square"></i> Live Demo
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    @php
        $projectsForModal = $projects->mapWithKeys(fn ($project) => [$project->id => [
            'title' => $project->translation('title'),
            'description' => $project->translation('description'),
            'category' => $project->translation('category'),
            'tags' => $project->tags,
            'image_path' => $project->image_path,
            'video_path' => $project->video_path,
            'video_url' => $project->video_url,
            'attachments' => $project->attachments,
            'github_url' => $project->github_url,
            'demo_url' => $project->demo_url,
        ]]);
    @endphp
    <script type="application/json" id="projects-data">@json($projectsForModal)</script>

    @if (! file_exists(public_path('build/manifest.json')))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const filterButtons = document.querySelectorAll('.filter-btn');
                const projectCards = document.querySelectorAll('.project-card');

                if (!filterButtons.length || !projectCards.length) {
                    return;
                }

                filterButtons.forEach((button) => {
                    button.addEventListener('click', () => {
                        filterButtons.forEach((item) => {
                            item.classList.remove('bg-indigo-600', 'text-white', 'border-indigo-600');
                            item.classList.add('bg-slate-900', 'text-slate-400', 'border-slate-800');
                        });

                        button.classList.remove('bg-slate-900', 'text-slate-400', 'border-slate-800');
                        button.classList.add('bg-indigo-600', 'text-white', 'border-indigo-600');

                        const filterValue = button.getAttribute('data-filter');
                        projectCards.forEach((card) => {
                            const matches = filterValue === 'all' || card.getAttribute('data-category') === filterValue;
                            card.style.display = matches ? 'flex' : 'none';
                        });
                    });
                });
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const dataElement = document.getElementById('projects-data');
                const modal = document.getElementById('project-modal');
                const closeButton = document.getElementById('modal-close-button');
                const backdrop = document.querySelector('[data-modal-backdrop]');

                if (!dataElement || !modal) {
                    return;
                }

                const getEmbedUrl = (url) => {
                    if (!url) {
                        return '';
                    }

                    try {
                        const parsedUrl = new URL(url);
                        const host = parsedUrl.hostname.replace('www.', '');

                        if (host === 'youtube.com' || host === 'm.youtube.com') {
                            const videoId = parsedUrl.searchParams.get('v');
                            return videoId ? `https://www.youtube.com/embed/${videoId}` : url;
                        }

                        if (host === 'youtu.be') {
                            return `https://www.youtube.com/embed/${parsedUrl.pathname.replace('/', '')}`;
                        }
                    } catch (error) {
                        return url;
                    }

                    return url;
                };

                let projects = {};

                try {
                    projects = JSON.parse(dataElement.textContent || '{}');
                } catch (error) {
                    console.error('Portfolio projects data could not be parsed.', error);
                }

                const closeModal = () => {
                    modal.classList.add('hidden');
                    document.body.style.overflow = '';
                };

                const openModal = (projectId) => {
                    const project = projects[projectId];

                    if (!project) {
                        return;
                    }

                    const mediaContainer = document.getElementById('modal-image-container');
                    const mediaInfo = document.getElementById('modal-media-info');
                    const category = document.getElementById('modal-category');
                    const title = document.getElementById('modal-title-text');
                    const description = document.getElementById('modal-description');
                    const tags = document.getElementById('modal-tags');
                    const github = document.getElementById('modal-github');
                    const demo = document.getElementById('modal-demo');

                    if (!mediaContainer || !mediaInfo || !category || !title || !description || !tags || !github || !demo) {
                        return;
                    }

                    mediaContainer.innerHTML = '';
                    mediaContainer.style.display = 'block';
                    mediaInfo.innerHTML = '';
                    tags.innerHTML = '';

                    const mediaSource = project.video_path || project.video_url;

                    if (mediaSource) {
                        const mediaUrl = project.video_path
                            ? `${window.location.origin}/storage/${project.video_path}`
                            : project.video_url;

                        if (project.video_url && !project.video_path) {
                            const iframe = document.createElement('iframe');
                            iframe.src = getEmbedUrl(project.video_url);
                            iframe.className = 'w-full h-full';
                            iframe.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture';
                            iframe.allowFullscreen = true;
                            iframe.title = project.title;
                            mediaContainer.appendChild(iframe);
                        } else {
                            const video = document.createElement('video');
                            video.src = mediaUrl;
                            video.className = 'w-full h-full object-cover';
                            video.controls = true;
                            video.preload = 'metadata';
                            mediaContainer.appendChild(video);
                        }
                    } else if (project.image_path) {
                        const image = document.createElement('img');
                        image.src = `${window.location.origin}/storage/${project.image_path}`;
                        image.alt = project.title;
                        image.className = 'w-full h-full object-cover';
                        mediaContainer.appendChild(image);
                    } else {
                        mediaContainer.style.display = 'none';
                    }

                    category.textContent = project.category || 'Category';
                    title.textContent = project.title || 'Project Title';
                    description.textContent = project.description || 'No description available.';

                    if (Array.isArray(project.tags)) {
                        project.tags.forEach((tag) => {
                            const badge = document.createElement('span');
                            badge.className = 'px-2.5 py-1 rounded bg-slate-950 border border-slate-800 text-[10px] font-semibold text-indigo-300';
                            badge.textContent = tag;
                            tags.appendChild(badge);
                        });
                    }

                    if (Array.isArray(project.attachments) && project.attachments.length > 0) {
                        const attachmentBlock = document.createElement('div');
                        attachmentBlock.className = 'rounded-2xl border border-slate-800 bg-slate-950/70 p-4';
                        attachmentBlock.innerHTML = `
                            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Project Attachments</h4>
                            <div class="flex flex-wrap gap-2"></div>
                        `;

                        const list = attachmentBlock.querySelector('div.flex-wrap');

                        project.attachments.forEach((file) => {
                            const link = document.createElement('a');
                            link.href = `${window.location.origin}/storage/${file}`;
                            link.target = '_blank';
                            link.rel = 'noopener';
                            link.className = 'inline-flex items-center gap-2 rounded-full border border-slate-800 bg-slate-900 px-3 py-1.5 text-xs font-semibold text-slate-300 hover:text-white';
                            link.innerHTML = `<i class="fa-solid fa-paperclip"></i> ${file.split('/').pop()}`;
                            list.appendChild(link);
                        });

                        mediaInfo.appendChild(attachmentBlock);
                    }

                    github.href = project.github_url || '#';
                    github.style.display = project.github_url ? 'inline-flex' : 'none';

                    demo.href = project.demo_url || '#';
                    demo.style.display = project.demo_url ? 'inline-flex' : 'none';

                    modal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                };

                document.querySelectorAll('[data-project-id]').forEach((trigger) => {
                    trigger.addEventListener('click', () => {
                        openModal(trigger.getAttribute('data-project-id'));
                    });
                });

                closeButton?.addEventListener('click', closeModal);
                backdrop?.addEventListener('click', closeModal);

                document.addEventListener('keydown', (event) => {
                    if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
                        closeModal();
                    }
                });
            });
        </script>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            if (prefersReducedMotion) {
                return;
            }

            document.querySelectorAll('.skill-orbit-card').forEach((card) => {
                card.addEventListener('pointermove', (event) => {
                    const rect = card.getBoundingClientRect();
                    const x = event.clientX - rect.left;
                    const y = event.clientY - rect.top;
                    const rotateY = ((x / rect.width) - 0.5) * 12;
                    const rotateX = (((y / rect.height) - 0.5) * -12);

                    card.style.setProperty('--skill-x', `${x}px`);
                    card.style.setProperty('--skill-y', `${y}px`);
                    card.style.setProperty('--skill-rotate-x', `${rotateX.toFixed(2)}deg`);
                    card.style.setProperty('--skill-rotate-y', `${rotateY.toFixed(2)}deg`);
                });

                card.addEventListener('pointerleave', () => {
                    card.style.removeProperty('--skill-rotate-x');
                    card.style.removeProperty('--skill-rotate-y');
                    card.style.removeProperty('--skill-x');
                    card.style.removeProperty('--skill-y');
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const copyButton = document.querySelector('[data-copy-email]');
            const copyLabel = document.querySelector('[data-copy-email-label]');

            if (!copyButton) {
                return;
            }

            const showCopiedStatus = () => {
                if (!copyLabel) {
                    return;
                }

                const originalLabel = copyLabel.textContent;
                copyLabel.textContent = 'Email Copied';

                window.setTimeout(() => {
                    copyLabel.textContent = originalLabel;
                }, 1800);
            };

            copyButton.addEventListener('click', async () => {
                const email = copyButton.getAttribute('data-copy-email');

                if (!email) {
                    return;
                }

                try {
                    if (navigator.clipboard && window.isSecureContext) {
                        await navigator.clipboard.writeText(email);
                    } else {
                        const input = document.createElement('input');
                        input.value = email;
                        input.setAttribute('readonly', '');
                        input.style.position = 'absolute';
                        input.style.left = '-9999px';
                        document.body.appendChild(input);
                        input.select();
                        document.execCommand('copy');
                        input.remove();
                    }

                    showCopiedStatus();
                } catch (error) {
                    window.prompt('Copy this email address:', email);
                }
            });
        });
    </script>
@endsection
