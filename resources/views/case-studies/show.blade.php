<x-layout.base title="{{ $project->title }} — VIVIO" description="{{ $project->short_description ?: $project->title }}">
    @php
        $desktopImage = $project->desktop_image ?: $project->featured_image ?: $project->media->firstWhere('type', 'image')?->path;
        $mobileImage = $project->mobile_image;
    @endphp
    <article class="vivio-case-study">
        <header class="vivio-case-hero">
            <div class="vivio-container">
                <div class="vivio-case-hero__top"><span>PROJECT / {{ str_pad((string) $project->sort_order, 2, '0', STR_PAD_LEFT) }}</span><span>{{ $project->year ?: 'VIVIO SYSTEM' }}</span></div>
                <div class="vivio-case-hero__copy"><span class="vivio-overline">{{ $project->category?->name ?: 'DIGITAL SYSTEM' }}</span><h1>{{ $project->title }}</h1><p>{{ $project->short_description }}</p></div>
                @if ($desktopImage)
                    <div class="vivio-case-hero__devices"><div class="vivio-case-device vivio-case-device--desktop"><div class="vivio-case-device__bar"><i></i><i></i><i></i></div><img src="{{ asset('storage/'.$desktopImage) }}" alt="{{ $project->title }}" fetchpriority="high"></div>@if ($mobileImage)<div class="vivio-case-device vivio-case-device--mobile"><div class="vivio-case-device__notch"></div><img src="{{ asset('storage/'.$mobileImage) }}" alt="{{ $project->title }} - mobile"></div>@endif</div>
                @endif
            </div>
        </header>

        <div class="vivio-container vivio-case-body">
            <div class="vivio-case-facts"><span>CATEGORY <b>{{ $project->category?->name ?: '—' }}</b></span>@if ($project->client)<span>CLIENT <b>{{ $project->client }}</b></span>@endif @if ($project->year)<span>YEAR <b>{{ $project->year }}</b></span>@endif</div>
            <div class="vivio-case-copy">
                @foreach ([['THE PROBLEM', $project->problem], ['OUR APPROACH', $project->approach], ['WHAT WE BUILT', $project->solution], ['THE RESULT', $project->result]] as [$label, $copy])
                    @if ($copy)<section><span class="vivio-overline">{{ $label }}</span><p>{{ $copy }}</p></section>@endif
                @endforeach
            </div>
            @if ($project->technologies)
                <section class="vivio-case-stack"><span class="vivio-overline">TECHNOLOGY</span><div>@foreach ($project->technologies as $technology)<span>{{ $technology }}</span>@endforeach</div></section>
            @endif
            @if ($project->team->isNotEmpty())
                <section class="vivio-case-team"><span class="vivio-overline">PROJECT TEAM</span>@foreach ($project->team as $member)<div><span>{{ $member->name }}</span><small>{{ $member->pivot->role_on_project }}</small>@if ($member->pivot->contribution_percent)<b>{{ $member->pivot->contribution_percent }}%</b>@endif</div>@endforeach</section>
            @endif
            @if ($project->media->where('type', 'image')->isNotEmpty())
                <div class="vivio-case-gallery">@foreach ($project->media->where('type', 'image') as $media)<img src="{{ asset('storage/'.$media->path) }}" alt="{{ $media->alt_text ?: $project->title }}" loading="lazy">@endforeach</div>
            @endif
            @if ($relatedProjects->isNotEmpty())
                <section class="vivio-case-related"><span class="vivio-overline">MORE PROJECTS</span><div>@foreach ($relatedProjects as $related)<a href="{{ route('projects.show', $related) }}"><span>{{ $related->sort_order }}</span><strong>{{ $related->title }}</strong><i>→</i></a>@endforeach</div></section>
            @endif
        </div>
    </article>
</x-layout.base>
