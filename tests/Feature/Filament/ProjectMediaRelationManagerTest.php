<?php

use App\Filament\Resources\Projects\Pages\EditProject;
use App\Filament\Resources\Projects\RelationManagers\MediaRelationManager;
use App\Models\Project;
use App\Models\ProjectMedia;
use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    Storage::fake('public');
    $this->actingAs(User::factory()->admin()->create());
    $this->project = Project::factory()->create();
});

function relationManager(Project $project)
{
    return Livewire::test(MediaRelationManager::class, [
        'ownerRecord' => $project,
        'pageClass' => EditProject::class,
    ]);
}

it('renders the media relation manager', function () {
    relationManager($this->project)->assertSuccessful();
});

it('lists project media', function () {
    $media = ProjectMedia::factory()->image()->create([
        'project_id' => $this->project->id,
        'alt_text' => 'Hero screenshot',
    ]);

    relationManager($this->project)
        ->assertSee('image')
        ->assertCanSeeTableRecords([$media]);
});

it('can attach image media to a project', function () {
    $file = UploadedFile::fake()->image('hero.jpg');

    relationManager($this->project)
        ->callAction(TestAction::make('create')->table(), data: [
            'type' => 'image',
            'path' => [$file],
            'alt_text' => 'Hero image',
            'caption' => 'Homepage hero',
            'sort_order' => 1,
        ])
        ->assertHasNoActionErrors();

    $media = $this->project->media()->first();

    expect($media)->not->toBeNull()
        ->type->toBe('image')
        ->alt_text->toBe('Hero image')
        ->sort_order->toBe(1);
});

it('can attach video media to a project', function () {
    $file = UploadedFile::fake()->create('demo.mp4', 500, 'video/mp4');

    relationManager($this->project)
        ->callAction(TestAction::make('create')->table(), data: [
            'type' => 'video',
            'path' => [$file],
            'sort_order' => 0,
        ])
        ->assertHasNoActionErrors();

    expect($this->project->media()->first())
        ->type->toBe('video');
});

it('rejects disallowed file types for images', function () {
    $file = UploadedFile::fake()->create('malware.exe', 10);

    relationManager($this->project)
        ->callAction(TestAction::make('create')->table(), data: [
            'type' => 'image',
            'path' => [$file],
        ])
        ->assertHasActionErrors(['path']);

    expect($this->project->media()->count())->toBe(0);
});

it('can edit project media', function () {
    $media = ProjectMedia::factory()->image()->create(['project_id' => $this->project->id]);

    relationManager($this->project)
        ->callAction(
            TestAction::make('edit')->table($media),
            data: [
                'type' => 'image',
                'path' => [$media->path],
                'alt_text' => 'Updated alt',
                'caption' => 'Updated caption',
                'sort_order' => 5,
            ],
        )
        ->assertHasNoActionErrors();

    expect($media->refresh())
        ->alt_text->toBe('Updated alt')
        ->caption->toBe('Updated caption')
        ->sort_order->toBe(5);
});

it('can delete project media', function () {
    $media = ProjectMedia::factory()->image()->create(['project_id' => $this->project->id]);

    relationManager($this->project)
        ->callAction(TestAction::make('delete')->table($media));

    expect(ProjectMedia::find($media->id))->toBeNull();
});

it('orders media by sort order', function () {
    ProjectMedia::factory()->image()->create(['project_id' => $this->project->id, 'sort_order' => 2]);
    ProjectMedia::factory()->image()->create(['project_id' => $this->project->id, 'sort_order' => 1]);

    $ordered = $this->project->media;

    expect($ordered->first()->sort_order)->toBe(1)
        ->and($ordered->last()->sort_order)->toBe(2);
});
