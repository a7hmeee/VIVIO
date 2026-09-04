@props([
    'projects' => collect(),
])

@php
    $projectImage = fn ($project) => $project->desktop_image ?: $project->featured_image ?: $project->media->firstWhere('type', 'image')?->path;
    $mobileImage = fn ($project) => $project->mobile_image;
@endphp

<section class="vivio-work" id="work" data-section="05">
    <div class="vivio-container">
        <div class="vivio-work__head">
            <span class="vivio-overline">VIVIO / 05 · SELECTED WORK</span>
            <div class="vivio-work__title-row">
                <h2 class="vivio-serif">SELECTED WORK</h2>
                <p class="vivio-work__subtitle">أشياء بنيناها، مش بس حكينا عنها.</p>
            </div>
        </div>

        @if ($projects->isNotEmpty())
            <div class="vivio-work__projects">
                @foreach ($projects as $index => $project)
                    @php
                        $img = $projectImage($project);
                        $mob = $mobileImage($project);
                        $number = str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT);
                        $layoutClass = 'vivio-work-project--'.(($index % 3) + 1);
                    @endphp

                    <article class="vivio-work-project {{ $layoutClass }}" data-work-project>
                        <div class="vivio-work-project__visual">
                            @if ($img)
                                <div class="vivio-work-project__media">
                                    <div class="vivio-work-project__desktop">
                                        <div class="vivio-device__bar"><i></i><i></i><i></i></div>
                                        <img src="{{ asset('storage/'.$img) }}" alt="{{ $project->title }}" loading="{{ $index === 0 ? 'eager' : 'lazy' }}">
                                    </div>
                                    @if ($mob)
                                        <div class="vivio-work-project__mobile">
                                            <div class="vivio-work-project__mobile-notch"></div>
                                            <img src="{{ asset('storage/'.$mob) }}" alt="{{ $project->title }} — mobile" loading="lazy">
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="vivio-work-project__fallback">
                                    <span class="vivio-work-project__index">{{ $number }}</span>
                                    <span class="vivio-work-project__fallback-label">PROJECT / {{ $project->category?->name ?: 'Digital System' }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="vivio-work-project__info">
                            <div class="vivio-work-project__eyebrow">
                                <span class="vivio-work-project__num">{{ $number }}</span>
                                <span class="vivio-work-project__cat">{{ $project->category?->name ?: 'Digital System' }}</span>
                            </div>
                            <h3 class="vivio-serif vivio-work-project__title">{{ $project->title }}</h3>
                            <p class="vivio-work-project__desc">{{ $project->short_description ?: \Illuminate\Support\Str::limit($project->problem, 160) }}</p>

                            @if ($project->technologies)
                                <div class="vivio-work-project__stack">
                                    <span class="vivio-overline">STACK</span>
                                    <div class="vivio-work-project__stack-list">
                                        @foreach (array_slice($project->technologies, 0, 5) as $tech)
                                            <span>{{ $tech }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($project->client || $project->year)
                                <div class="vivio-work-project__meta">
                                    @if ($project->client)<span>CLIENT / {{ $project->client }}</span>@endif
                                    @if ($project->year)<span>YEAR / {{ $project->year }}</span>@endif
                                </div>
                            @endif

                            <a href="{{ route('case-studies.show', $project) }}" class="vivio-work-project__link">VIEW CASE STUDY ↗</a>
                        </div>
                    </article>
                @endforeach
            </div>

            <a href="{{ route('projects') }}" class="vivio-work__all">عرض جميع المشاريع <span>→</span></a>
        @else
            <div class="vivio-work__empty">
                <span class="vivio-overline">PROJECTS / COMING SOON</span>
                <p>المشاريع قيد التحضير. ستظهر هنا فور نشرها.</p>
            </div>
        @endif
    </div>
</section>
