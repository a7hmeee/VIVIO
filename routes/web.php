<?php

use App\Livewire\ProjectsPage;
use App\Enums\LeadStatus;
use App\Models\Article;
use App\Models\Client;
use App\Models\Lead;
use App\Models\Project;
use App\Models\Setting;
use App\Models\TeamMember;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

Route::get('/', function () {
    if (! Schema::hasTable('projects')) {
        return view('welcome', [
            'projects' => collect(),
            'teamMembers' => collect(),
            'articles' => collect(),
            'clients' => collect(),
            'testimonials' => collect(),
            'contactEmail' => 'hello@vivio.studio',
        ]);
    }

    return view('welcome', [
        'projects' => Project::published()->ordered()->with(['category', 'media', 'team'])->get(),
        'teamMembers' => Schema::hasTable('team_members') ? TeamMember::active()->ordered()->get() : collect(),
        'articles' => Article::latestPublished(3)->with(['category', 'author'])->get(),
        'clients' => Client::featured()->ordered()->get(),
        'testimonials' => Testimonial::published()->featured()->ordered()->with(['client', 'project'])->get(),
        'contactEmail' => Schema::hasTable('settings') ? Setting::get('contact_email', 'hello@vivio.studio') : 'hello@vivio.studio',
    ]);
})->name('home');

Route::get('/projects', ProjectsPage::class)->name('projects');
Route::get('/work', fn () => redirect()->route('projects'))->name('work');

Route::get('/projects/{project:slug}', function (Project $project) {
    abort_unless($project->is_published && $project->published_at?->isPast(), 404);

    return view('case-studies.show', [
        'project' => $project->load(['category', 'media', 'team']),
        'relatedProjects' => Project::published()->whereKeyNot($project->getKey())->ordered()->with(['category', 'media'])->limit(3)->get(),
    ]);
})->name('projects.show');

Route::get('/case-studies/{project:slug}', function (Project $project) {
    abort_unless($project->is_published && $project->published_at?->isPast(), 404);

    return view('case-studies.show', [
        'project' => $project->load(['category', 'media', 'team']),
        'relatedProjects' => Project::published()->whereKeyNot($project->getKey())->ordered()->with(['category', 'media'])->limit(3)->get(),
    ]);
})->name('case-studies.show');

if (Schema::hasTable('leads')) {
    Route::post('/contact', function (Illuminate\Http\Request $request) {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'project_type' => ['required', 'string', 'max:100'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        Lead::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'project_type' => $validated['project_type'],
            'message' => $validated['message'],
            'status' => LeadStatus::New->value,
            'source' => 'homepage',
        ]);

        return back()->with('contact_success', 'تم استلام تفاصيل مشروعك بنجاح. سنتواصل معك قريبًا.');
    })->name('contact.submit');
}
