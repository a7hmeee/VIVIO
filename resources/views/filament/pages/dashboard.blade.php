<x-filament-panels::page>
    @php
        $hour = (int) now()->format('H');
        $greeting = match (true) {
            $hour < 5 => 'Good night',
            $hour < 12 => 'Good morning',
            $hour < 17 => 'Good afternoon',
            default => 'Good evening',
        };
        $firstName = str(auth()->user()?->name ?? 'Operator')->explode(' ')->first();

        $metrics = [
            ['01', 'PROJECTS', \App\Models\Project::count(), \App\Models\Project::published()->count().' published', \App\Filament\Resources\Projects\ProjectResource::getUrl('index')],
            ['02', 'ARTICLES', \App\Models\Article::count(), \App\Models\Article::published()->count().' published', \App\Filament\Resources\Articles\ArticleResource::getUrl('index')],
            ['03', 'LEADS', \App\Models\Lead::count(), \App\Models\Lead::new()->count().' new', \App\Filament\Resources\Leads\LeadResource::getUrl('index')],
            ['04', 'CLIENTS', \App\Models\Client::count(), \App\Models\Client::featured()->count().' featured', \App\Filament\Resources\Clients\ClientResource::getUrl('index')],
            ['05', 'TESTIMONIALS', \App\Models\Testimonial::count(), \App\Models\Testimonial::published()->count().' published', \App\Filament\Resources\Testimonials\TestimonialResource::getUrl('index')],
        ];

        $recentProjects = \App\Models\Project::query()
            ->with('category')
            ->orderByDesc('updated_at')
            ->limit(4)
            ->get();

        $recentLeads = \App\Models\Lead::query()
            ->orderByDesc('created_at')
            ->limit(6)
            ->get();
    @endphp

    <div class="vivio-admin">

        {{-- ============ HERO ============ --}}
        <section class="vivio-hero">
            <div class="vivio-hero-meta">
                <span class="vivio-overline">VIVIO / ADMIN</span>
                <div class="vivio-hero-meta-cells">
                    <span>SYS / 001</span>
                    <span>CONTROL CENTER</span>
                    <span>{{ now()->format('D · d M Y') }}</span>
                </div>
            </div>

            <div class="vivio-hero-grid">
                <div class="vivio-hero-headline">
                    <p class="vivio-hero-greeting">{{ $greeting }}, {{ $firstName }}.</p>
                    <h1 class="vivio-hero-title">BUILD.<br>PUBLISH.<br>OPERATE.</h1>
                    <p class="vivio-hero-tagline">Your digital workspace — projects, editorial, clients and leads operated as one system.</p>
                    <div class="vivio-hero-actions">
                        <a href="{{ \App\Filament\Resources\Projects\ProjectResource::getUrl('create') }}" class="vivio-btn vivio-btn--primary">+ New Project</a>
                        <a href="{{ \App\Filament\Resources\Leads\LeadResource::getUrl('index') }}" class="vivio-btn vivio-btn--ghost">View Leads</a>
                    </div>
                </div>

                <div class="vivio-hero-visual" aria-hidden="true">
                    <div class="vivio-hero-canvas">
                        <img src="{{ asset('robot.png') }}" alt="" class="vivio-hero-robot">
                        <div class="vivio-hero-canvas-meta vivio-hero-canvas-meta--top">
                            <span>VIVIO / 001</span>
                            <span class="is-online">SYSTEM ONLINE</span>
                        </div>
                        <div class="vivio-hero-canvas-meta vivio-hero-canvas-meta--bottom">
                            <span>OPERATOR</span>
                            <span>{{ strtoupper($firstName) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ============ METRICS ============ --}}
        <section class="vivio-metrics" role="list">
            @foreach ($metrics as [$index, $label, $value, $foot, $url])
                <a href="{{ $url }}" class="vivio-metric" role="listitem">
                    <span class="vivio-metric-top">
                        <span class="vivio-metric-index">{{ $index }}</span>
                        <span class="vivio-metric-label">{{ $label }}</span>
                    </span>
                    <span class="vivio-metric-value">{{ str_pad((string) $value, 2, '0', STR_PAD_LEFT) }}</span>
                    <span class="vivio-metric-foot">{{ $foot }}</span>
                </a>
            @endforeach
        </section>

        {{-- ============ PROJECTS + LEADS ============ --}}
        <section class="vivio-dashboard-grid">
            <div>
                <header class="vivio-section-header">
                    <span class="vivio-overline">RECENT PROJECTS</span>
                    <a href="{{ \App\Filament\Resources\Projects\ProjectResource::getUrl('index') }}">ALL PROJECTS</a>
                </header>

                @if ($recentProjects->isEmpty())
                    <div class="vivio-rail-block">
                        <div class="vivio-empty">
                            <img src="{{ asset('robot.png') }}" alt="" aria-hidden="true">
                            <p class="vivio-empty-title">No projects yet</p>
                            <p class="vivio-empty-text">Your published projects will appear here.</p>
                            <a href="{{ \App\Filament\Resources\Projects\ProjectResource::getUrl('create') }}" class="vivio-btn vivio-btn--dark">+ Create first project</a>
                        </div>
                    </div>
                @else
                    <div class="vivio-projects-grid">
                        @foreach ($recentProjects as $i => $project)
                            <a href="{{ \App\Filament\Resources\Projects\ProjectResource::getUrl('edit', ['record' => $project->getRouteKey()]) }}" class="vivio-project-card">
                                <div class="vivio-project-card-art">
                                    @if ($project->featured_image)
                                        <img src="{{ asset('storage/'.$project->featured_image) }}" alt="{{ $project->title }}">
                                    @else
                                        <div class="vivio-project-card-art--empty">{{ $project->category?->name ?? 'VIVIO CASE' }}</div>
                                    @endif
                                </div>
                                <div class="vivio-project-card-body">
                                    <span class="vivio-project-card-index">PROJECT / {{ str_pad((string) ($i + 1), 3, '0', STR_PAD_LEFT) }}</span>
                                    <h3 class="vivio-project-card-title">{{ $project->title }}</h3>
                                    <div class="vivio-project-card-meta">
                                        <span>{{ $project->category?->name ?? '—' }}</span>
                                        <span>{{ $project->year ?? '—' }}</span>
                                        <span class="{{ $project->is_published ? 'is-live' : '' }}">{{ $project->is_published ? 'LIVE' : 'DRAFT' }}</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <aside class="vivio-rail">
                <div class="vivio-rail-block">
                    <header class="vivio-section-header">
                        <span class="vivio-overline">RECENT LEADS</span>
                        <a href="{{ \App\Filament\Resources\Leads\LeadResource::getUrl('index') }}">PIPELINE</a>
                    </header>

                    @if ($recentLeads->isEmpty())
                        <div class="vivio-empty">
                            <p class="vivio-empty-title">No leads yet</p>
                            <p class="vivio-empty-text">New inquiries will land here in real time.</p>
                        </div>
                    @else
                        <ul class="vivio-rail-list">
                            @foreach ($recentLeads as $lead)
                                <li>
                                    <a href="{{ \App\Filament\Resources\Leads\LeadResource::getUrl('index') }}" class="vivio-lead-row">
                                        <span class="vivio-lead-time">{{ $lead->created_at?->format('H:i') }}</span>
                                        <span class="vivio-lead-body">
                                            <span class="vivio-lead-name">{{ $lead->name }}@if($lead->company) · {{ $lead->company }}@endif</span>
                                            <span class="vivio-lead-type">{{ $lead->project_type }}</span>
                                        </span>
                                        <span class="vivio-lead-status {{ $lead->status === \App\Enums\LeadStatus::New ? 'vivio-lead-status--new' : '' }}">{{ strtoupper($lead->status->value) }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="vivio-rail-block">
                    <header class="vivio-section-header">
                        <span class="vivio-overline">SHORTCUTS</span>
                    </header>
                    <ul class="vivio-rail-list">
                        <li><a href="{{ \App\Filament\Resources\Media\MediaResource::getUrl('index') }}" class="vivio-lead-row"><span class="vivio-lead-time">M</span><span class="vivio-lead-body"><span class="vivio-lead-name">Media library</span></span></a></li>
                        <li><a href="{{ \App\Filament\Resources\Clients\ClientResource::getUrl('index') }}" class="vivio-lead-row"><span class="vivio-lead-time">C</span><span class="vivio-lead-body"><span class="vivio-lead-name">Clients</span></span></a></li>
                        <li><a href="{{ \App\Filament\Resources\Testimonials\TestimonialResource::getUrl('index') }}" class="vivio-lead-row"><span class="vivio-lead-time">T</span><span class="vivio-lead-body"><span class="vivio-lead-name">Testimonials</span></span></a></li>
                        <li><a href="{{ \App\Filament\Resources\Articles\ArticleResource::getUrl('create') }}" class="vivio-lead-row"><span class="vivio-lead-time">+</span><span class="vivio-lead-body"><span class="vivio-lead-name">New article</span></span></a></li>
                    </ul>
                </div>
            </aside>
        </section>
    </div>
</x-filament-panels::page>
