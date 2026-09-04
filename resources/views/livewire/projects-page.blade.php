<div class="vivio-projects-page">
    <section class="vivio-projects-hero">
        <div class="vivio-projects-hero__bg" aria-hidden="true"><div class="vivio-projects-hero__grid"></div><div class="vivio-projects-hero__radial"></div></div>
        <div class="vivio-container vivio-projects-hero__layout">
            <div class="vivio-projects-hero__copy">
                <span class="vivio-overline">VIVIO / WORK / 001</span>
                <h1 class="vivio-serif vivio-projects-hero__title">WE DON'T JUST<br><em>TALK ABOUT IT.</em><br>WE BUILD IT.</h1>
                <p class="vivio-projects-hero__arabic">مشاريع حقيقية. أنظمة حقيقية. نتائج حقيقية.</p>
                <p class="vivio-projects-hero__desc">نحوّل المشاكل التشغيلية والأفكار المعقدة إلى مواقع وأنظمة ومنصات رقمية قابلة للاستخدام.</p>
                <div class="vivio-projects-hero__stats"><div><b>{{ $stats['projects'] }}</b><span>PROJECTS</span></div><div><b><i></i> ONLINE</b><span>SYSTEM STATUS</span></div></div>
            </div>
            <div class="vivio-projects-hero__visual"><x-robot.interactive variant="hero" size="medium" /></div>
        </div>
    </section>

    <section class="vivio-projects-filters" aria-label="تصفية المشاريع">
        <div class="vivio-container vivio-projects-filters__inner">
            <button type="button" class="vivio-projects-filters__item {{ $activeFilter === 'all' ? 'is-active' : '' }}" wire:click="setFilter('all')">ALL</button>
            @foreach ($categories as $category)
                <button type="button" class="vivio-projects-filters__item {{ $activeFilter === $category->slug ? 'is-active' : '' }}" wire:click="setFilter('{{ $category->slug }}')">{{ $category->name }}</button>
            @endforeach
        </div>
    </section>

    @if ($projects->isNotEmpty())
        @foreach ($projects as $index => $project)
            @php
                $number = str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT);
                $desktopImage = $project->desktop_image ?: $project->featured_image ?: $project->media->firstWhere('type', 'image')?->path;
                $mobileImage = $project->mobile_image;
                $isFeatured = $index === 0;
            @endphp
            <article class="vivio-project-entry {{ $isFeatured ? 'vivio-project-entry--featured' : '' }} {{ $index % 2 ? 'vivio-project-entry--reverse' : '' }}" id="project-{{ $project->slug }}">
                <div class="vivio-container vivio-project-entry__layout">
                    <div class="vivio-project-entry__info">
                        <div class="vivio-project-entry__eyebrow"><span>{{ $number }} / {{ str_pad((string) $projects->count(), 2, '0', STR_PAD_LEFT) }}</span><span>{{ $project->category?->name }}</span></div>
                        <h2 class="vivio-serif vivio-project-entry__title">{{ $project->title }}</h2>
                        <p class="vivio-project-entry__desc">{{ $project->short_description }}</p>
                        <div class="vivio-project-entry__facts">
                            @foreach ([['المشكلة', $project->problem], ['ما قمنا به', $project->solution], ['النتيجة', $project->result]] as [$label, $value])
                                @if ($value)<div><strong>{{ $label }}</strong><p>{{ \Illuminate\Support\Str::limit($value, 125) }}</p></div>@endif
                            @endforeach
                        </div>
                        @if ($project->technologies)
                            <div class="vivio-project-entry__stack"><span class="vivio-overline">STACK</span><div>@foreach ($project->technologies as $tech)<span>{{ $tech }}</span>@endforeach</div></div>
                        @endif
                        @if ($project->team->isNotEmpty())
                            <div class="vivio-project-entry__team"><span class="vivio-overline">PROJECT TEAM</span>@foreach ($project->team as $member)<div><span>{{ $member->name }}</span><small>{{ $member->pivot->role_on_project }}</small>@if ($member->pivot->contribution_percent)<b>{{ $member->pivot->contribution_percent }}%</b>@endif</div>@endforeach</div>
                        @endif
                        <div class="vivio-project-entry__meta">@if ($project->client)<span>CLIENT / {{ $project->client }}</span>@endif @if ($project->year)<span>YEAR / {{ $project->year }}</span>@endif</div>
                        <a href="{{ route('projects.show', $project) }}" class="vivio-project-entry__link">عرض المشروع <span>→</span></a>
                    </div>
                    <div class="vivio-project-entry__visual">
                        @if ($desktopImage)
                            <div class="vivio-device vivio-device--desktop"><div class="vivio-device__bar"><i></i><i></i><i></i></div><img src="{{ asset('storage/'.$desktopImage) }}" alt="{{ $project->title }}" loading="{{ $isFeatured ? 'eager' : 'lazy' }}"></div>
                            @if ($mobileImage)<div class="vivio-device vivio-device--mobile"><div class="vivio-device__notch"></div><img src="{{ asset('storage/'.$mobileImage) }}" alt="{{ $project->title }} - mobile" loading="lazy"></div>@endif
                        @else
                            <div class="vivio-project-entry__no-image"><span>IMAGE / PENDING</span><small>أضف صورة سطح المكتب من لوحة التحكم</small></div>
                        @endif
                    </div>
                </div>
            </article>
        @endforeach
    @else
        <div class="vivio-container vivio-projects-empty"><span class="vivio-overline">PROJECTS / EMPTY</span><h2 class="vivio-serif">لا توجد مشاريع منشورة ضمن هذا التصنيف.</h2><p>سيظهر العمل هنا تلقائياً بعد نشر مشروع من لوحة التحكم.</p></div>
    @endif

    <section class="vivio-projects-process"><div class="vivio-container"><span class="vivio-overline">VIVIO / PROCESS</span><h2 class="vivio-serif">من الفكرة إلى النظام.</h2><div class="vivio-projects-process__track">@foreach ([['01','DISCOVER'],['02','DESIGN'],['03','BUILD'],['04','LAUNCH']] as [$num,$label])<div><b>{{ $num }}</b><strong>{{ $label }}</strong></div>@endforeach</div></div></section>
    <section class="vivio-projects-cta"><div class="vivio-container vivio-projects-cta__layout"><div><span class="vivio-overline">VIVIO / NEXT BUILD</span><h2 class="vivio-serif">عندك مشروع جديد؟</h2><p>خلينا نبني النظام الذي يحتاجه عملك.</p><a href="{{ route('home') }}#contact" class="vivio-button vivio-button--primary">ابدأ مشروعك الآن <span>→</span></a></div><x-robot.interactive variant="cta" size="small" /></div></section>
</div>
