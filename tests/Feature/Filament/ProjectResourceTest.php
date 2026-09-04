<?php

use App\Filament\Resources\Projects\Pages\CreateProject;
use App\Filament\Resources\Projects\Pages\EditProject;
use App\Filament\Resources\Projects\Pages\ListProjects;
use App\Models\Category;
use App\Models\Project;
use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->actingAs(User::factory()->admin()->create());
});

function projectData(): array
{
    return [
        'category_id' => Category::factory()->create()->id,
        'title' => 'Riyadh Metro Campaign',
        'slug' => 'riyadh-metro-campaign',
        'short_description' => 'A digital campaign for Riyadh Metro.',
        'client' => 'Royal Commission',
        'technologies' => ['Laravel', 'Livewire'],
        'year' => 2026,
        'problem' => 'Low ridership awareness.',
        'approach' => 'Interactive storytelling.',
        'solution' => 'Immersive microsite.',
        'result' => '45% increase in ridership.',
        'is_featured' => true,
        'is_published' => true,
        'published_at' => '2026-01-15 10:00:00',
        'sort_order' => 3,
    ];
}

it('renders the projects list page', function () {
    Livewire::test(ListProjects::class)->assertSuccessful();
});

it('renders the create project page', function () {
    Livewire::test(CreateProject::class)->assertSuccessful();
});

it('lists projects in the table', function () {
    $project = Project::factory()->create(['title' => 'Metro Campaign']);

    Livewire::test(ListProjects::class)
        ->assertSee('Metro Campaign')
        ->assertCanSeeTableRecords([$project]);
});

it('can create a project through the admin form', function () {
    Livewire::test(CreateProject::class)
        ->fillForm(projectData())
        ->call('create')
        ->assertHasNoFormErrors();

    $project = Project::where('slug', 'riyadh-metro-campaign')->first();

    expect($project)->not->toBeNull()
        ->and($project->client)->toBe('Royal Commission')
        ->and($project->technologies)->toBeArray()
        ->and($project->is_published)->toBeTrue()
        ->and($project->sort_order)->toBe(3);
});

it('validates required fields when creating a project', function () {
    Livewire::test(CreateProject::class)
        ->fillForm(['title' => null])
        ->call('create')
        ->assertHasFormErrors(['title']);
});

it('requires a valid category when creating a project', function () {
    $data = projectData();
    $data['category_id'] = 99999;

    Livewire::test(CreateProject::class)
        ->fillForm($data)
        ->call('create')
        ->assertHasFormErrors(['category_id']);
});

it('can edit a project through the admin form', function () {
    $project = Project::factory()->create();

    Livewire::test(EditProject::class, ['record' => $project->getRouteKey()])
        ->fillForm([
            'title' => 'Updated Title',
            'client' => 'New Client',
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($project->refresh())
        ->title->toBe('Updated Title')
        ->client->toBe('New Client');
});

it('can delete a project from the list page', function () {
    $project = Project::factory()->create();

    Livewire::test(ListProjects::class)
        ->callAction(TestAction::make('delete')->table($project));

    expect(Project::find($project->id))->toBeNull();
});

it('filters projects by category', function () {
    $webDesign = Category::factory()->create(['name' => 'Web Design']);
    $branding = Category::factory()->create(['name' => 'Branding']);

    $inCategory = Project::factory()->create(['category_id' => $webDesign->id]);
    $other = Project::factory()->create(['category_id' => $branding->id]);

    Livewire::test(ListProjects::class)
        ->filterTable('category', ['value' => $webDesign->id])
        ->assertCanSeeTableRecords([$inCategory])
        ->assertCanNotSeeTableRecords([$other]);
});

it('filters projects by published status', function () {
    $published = Project::factory()->published()->create();
    $draft = Project::factory()->unpublished()->create();

    Livewire::test(ListProjects::class)
        ->filterTable('is_published', ['value' => '1'])
        ->assertCanSeeTableRecords([$published])
        ->assertCanNotSeeTableRecords([$draft]);
});

it('denies access to guests on project pages', function () {
    auth()->logout();

    $this->get('/admin/projects')->assertRedirect('/admin/login');
    $this->get('/admin/projects/create')->assertRedirect('/admin/login');
});
