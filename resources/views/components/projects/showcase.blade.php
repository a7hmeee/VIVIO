@if ($projects->isNotEmpty())
    <div class="vivio-home-work">
        @foreach ($projects->take(4) as $index => $project)
            @php
                $image = $project->desktop_image ?: $project->featured_image ?: $project->media->firstWhere('type', 'image')?->path;
                $mobileImage = $project->mobile_image;
            @endphp
            <article class="vivio-home-work__item {{ $index === 0 ? 'is-featured' : '' }}">
                <a href="{{ route('projects.show', $project) }}" class="vivio-home-work__visual">
                    @if ($image)<img src="{{ asset('storage/'.$image) }}" alt="{{ $project->title }}" loading="{{ $index === 0 ? 'eager' : 'lazy' }}">@else<span class="vivio-home-work__no-image">IMAGE / PENDING</span>@endif
                    @if ($mobileImage)<span class="vivio-home-work__mobile"><img src="{{ asset('storage/'.$mobileImage) }}" alt="" loading="lazy"></span>@endif
                    <span class="vivio-home-work__number">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                </a>
                <div class="vivio-home-work__info">
                    <span class="vivio-overline">{{ $project->category?->name }}</span>
                    <h3 class="vivio-serif">{{ $project->title }}</h3>
                    @if ($project->short_description)<p>{{ $project->short_description }}</p>@endif
                    <div class="vivio-home-work__facts">
                        @foreach ([['المشكلة', $project->problem], ['ما قمنا به', $project->solution], ['النتيجة', $project->result]] as [$label, $value])
                            @if ($value)<div><strong>{{ $label }}</strong><span>{{ \Illuminate\Support\Str::limit($value, 74) }}</span></div>@endif
                        @endforeach
                    </div>
                    @if ($project->technologies)<div class="vivio-home-work__tags">@foreach (array_slice($project->technologies, 0, 5) as $tech)<span>{{ $tech }}</span>@endforeach</div>@endif
                    <a href="{{ route('projects.show', $project) }}" class="vivio-home-work__link">عرض المشروع <span>→</span></a>
                </div>
            </article>
        @endforeach
        <a href="{{ route('projects') }}" class="vivio-home-work__all">شوف كل مشاريعنا <span>→</span></a>
    </div>
@else
    <div class="vivio-projects-empty"><span class="vivio-overline">VIVIO / WORK</span><h3 class="vivio-serif">لا توجد مشاريع منشورة بعد.</h3><p>أضف المشاريع من لوحة التحكم لتظهر هنا وفي صفحة أعمالنا.</p><a href="{{ route('projects') }}" class="vivio-button vivio-button--primary">صفحة المشاريع <span>→</span></a></div>
@endif
