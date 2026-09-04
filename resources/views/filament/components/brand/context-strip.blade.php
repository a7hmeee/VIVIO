@php
    $route = request()->route()?->getName() ?? '';

    $contexts = [
        'filament.admin.pages.dashboard' => ['VIVIO / CONTROL CENTER', 'SYS / 001'],
        'filament.admin.resources.projects.index' => ['VIVIO / WORK', 'PROJECTS'],
        'filament.admin.resources.projects.create' => ['VIVIO / WORK', 'PROJECT / NEW'],
        'filament.admin.resources.projects.edit' => ['VIVIO / WORK', 'PROJECT / EDIT'],
        'filament.admin.resources.articles.index' => ['VIVIO / EDITORIAL', 'ARTICLES'],
        'filament.admin.resources.articles.create' => ['VIVIO / EDITORIAL', 'ARTICLE / NEW'],
        'filament.admin.resources.articles.edit' => ['VIVIO / EDITORIAL', 'ARTICLE / EDIT'],
        'filament.admin.resources.media.index' => ['VIVIO / LIBRARY', 'MEDIA'],
        'filament.admin.resources.categories.index' => ['VIVIO / TAXONOMY', 'CATEGORIES'],
        'filament.admin.resources.article-categories.index' => ['VIVIO / TAXONOMY', 'ARTICLE CATEGORIES'],
        'filament.admin.resources.leads.index' => ['VIVIO / PIPELINE', 'LEADS'],
        'filament.admin.resources.clients.index' => ['VIVIO / CLIENTS', 'CLIENTS'],
        'filament.admin.resources.testimonials.index' => ['VIVIO / VOICES', 'TESTIMONIALS'],
        'filament.admin.pages.manage-settings' => ['VIVIO / SYSTEM', 'SETTINGS'],
    ];

    $context = $contexts[$route] ?? null;
@endphp

@if ($context)
    <div class="vivio-context-strip">
        <span class="vivio-strip-label">{{ $context[0] }}</span>
        <span class="vivio-strip-meta">{{ $context[1] }}</span>
    </div>
@endif
