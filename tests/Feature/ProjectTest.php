<?php

use App\Models\Category;
use App\Models\Project;
use App\Models\ProjectMedia;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can create a project', function () {
    $project = Project::factory()->create();

    expect($project)->toBeInstanceOf(Project::class)
        ->and($project->title)->not->toBeEmpty()
        ->and($project->slug)->not->toBeEmpty();
});

it('auto generates slug from title', function () {
    $project = Project::factory()->create([
        'title' => 'E-Commerce Platform',
        'slug' => '',
    ]);

    expect($project->slug)->toBe('e-commerce-platform');
});

it('updates slug when title changes', function () {
    $project = Project::factory()->create(['title' => 'Original Title']);

    $project->update(['title' => 'New Title']);

    expect($project->slug)->toBe('new-title');
});

it('has unique slug constraint', function () {
    Project::factory()->create(['slug' => 'my-project']);

    Project::factory()->create(['slug' => 'my-project']);
})->throws(QueryException::class);

it('belongs to a category', function () {
    $category = Category::factory()->create();
    $project = Project::factory()->create(['category_id' => $category->id]);

    expect($project->category)->toBeInstanceOf(Category::class)
        ->and($project->category->id)->toBe($category->id);
});

it('can have many media items', function () {
    $project = Project::factory()->create();

    $project->media()->saveMany([
        ProjectMedia::factory()->image()->make(),
        ProjectMedia::factory()->video()->make(),
    ]);

    expect($project->media)->toHaveCount(2);
});

it('can get images only', function () {
    $project = Project::factory()->create();

    ProjectMedia::factory()->image()->create(['project_id' => $project->id]);
    ProjectMedia::factory()->image()->create(['project_id' => $project->id]);
    ProjectMedia::factory()->video()->create(['project_id' => $project->id]);

    expect($project->images)->toHaveCount(2);
});

it('can get videos only', function () {
    $project = Project::factory()->create();

    ProjectMedia::factory()->video()->create(['project_id' => $project->id]);
    ProjectMedia::factory()->image()->create(['project_id' => $project->id]);

    expect($project->videos)->toHaveCount(1);
});

it('can get documents only', function () {
    $project = Project::factory()->create();

    ProjectMedia::factory()->document()->create(['project_id' => $project->id]);
    ProjectMedia::factory()->image()->create(['project_id' => $project->id]);

    expect($project->documents)->toHaveCount(1);
});

it('can be featured', function () {
    $project = Project::factory()->featured()->create();

    expect($project->is_featured)->toBeTrue();
});

it('can be unpublished', function () {
    $project = Project::factory()->unpublished()->create();

    expect($project->is_published)->toBeFalse()
        ->and($project->published_at)->toBeNull();
});

it('can store technologies as json', function () {
    $project = Project::factory()->create([
        'technologies' => ['Laravel', 'Livewire', 'Tailwind'],
    ]);

    expect($project->technologies)->toBeArray()
        ->and($project->technologies)->toHaveCount(3)
        ->and($project->technologies)->toContain('Laravel');
});

it('can get technologies list attribute', function () {
    $project = Project::factory()->create([
        'technologies' => ['Laravel', 'Livewire'],
    ]);

    expect($project->technologies_list)->toBe('Laravel, Livewire');
});

it('scope published returns only published projects', function () {
    Project::factory()->published()->create(['published_at' => now()->subDay()]);
    Project::factory()->published()->create(['published_at' => now()->subDay()]);
    Project::factory()->unpublished()->create();

    $published = Project::published()->get();

    expect($published)->toHaveCount(2);
});

it('scope published does not return future projects', function () {
    Project::factory()->published()->create(['published_at' => now()->addDay()]);

    $published = Project::published()->get();

    expect($published)->toHaveCount(0);
});

it('scope featured returns only featured projects', function () {
    Project::factory()->featured()->create();
    Project::factory()->featured()->create();
    Project::factory()->create();

    $featured = Project::featured()->get();

    expect($featured)->toHaveCount(2);
});

it('scope ordered sorts by sort_order then published_at', function () {
    Project::factory()->create(['sort_order' => 2, 'published_at' => now()->subDay()]);
    Project::factory()->create(['sort_order' => 1, 'published_at' => now()]);
    Project::factory()->create(['sort_order' => 1, 'published_at' => now()->subDays(2)]);

    $ordered = Project::ordered()->get();

    expect($ordered->first()->sort_order)->toBe(1)
        ->and($ordered->last()->sort_order)->toBe(2);
});

it('scope for year filters by year', function () {
    Project::factory()->create(['year' => 2024]);
    Project::factory()->create(['year' => 2024]);
    Project::factory()->create(['year' => 2023]);

    $projects = Project::forYear(2024)->get();

    expect($projects)->toHaveCount(2);
});

it('scope in category filters by category slug', function () {
    $category = Category::factory()->create(['slug' => 'web-design']);
    Project::factory()->create(['category_id' => $category->id]);
    Project::factory()->create(); // different category

    $projects = Project::inCategory('web-design')->get();

    expect($projects)->toHaveCount(1);
});

it('scope with technologies filters by json contains', function () {
    Project::factory()->create(['technologies' => ['Laravel', 'Livewire']]);
    Project::factory()->create(['technologies' => ['React', 'Node.js']]);
    Project::factory()->create(['technologies' => ['Laravel', 'Vue']]);

    $projects = Project::withTechnologies(['Laravel'])->get();

    expect($projects)->toHaveCount(2);
});

it('uses slug as route key name', function () {
    $project = Project::factory()->create(['slug' => 'my-awesome-project']);

    $found = Project::where('slug', 'my-awesome-project')->first();

    expect($found->slug)->toBe('my-awesome-project');
});

it('can serialize to array', function () {
    $project = Project::factory()->create();

    $array = $project->toArray();

    expect($array)->toHaveKeys([
        'id', 'category_id', 'title', 'slug', 'short_description',
        'client', 'technologies', 'year', 'is_featured', 'is_published',
        'published_at', 'sort_order', 'created_at', 'updated_at',
    ]);
});

it('cascades delete to media', function () {
    $project = Project::factory()->create();
    ProjectMedia::factory()->count(3)->create(['project_id' => $project->id]);

    $project->delete();

    expect(ProjectMedia::where('project_id', $project->id)->count())->toBe(0);
});
