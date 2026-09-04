<?php

use App\Models\Project;
use App\Models\ProjectMedia;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can create project media', function () {
    $media = ProjectMedia::factory()->image()->create();

    expect($media)->toBeInstanceOf(ProjectMedia::class)
        ->and($media->type)->toBe('image')
        ->and($media->path)->not->toBeEmpty();
});

it('belongs to a project', function () {
    $project = Project::factory()->create();
    $media = ProjectMedia::factory()->image()->create(['project_id' => $project->id]);

    expect($media->project)->toBeInstanceOf(Project::class)
        ->and($media->project->id)->toBe($project->id);
});

it('can be an image', function () {
    $media = ProjectMedia::factory()->image()->create();

    expect($media->isImage())->toBeTrue()
        ->and($media->isVideo())->toBeFalse()
        ->and($media->isDocument())->toBeFalse();
});

it('can be a video', function () {
    $media = ProjectMedia::factory()->video()->create();

    expect($media->isVideo())->toBeTrue()
        ->and($media->isImage())->toBeFalse();
});

it('can be a document', function () {
    $media = ProjectMedia::factory()->document()->create();

    expect($media->isDocument())->toBeTrue()
        ->and($media->isImage())->toBeFalse();
});

it('scope of type filters correctly', function () {
    ProjectMedia::factory()->image()->create();
    ProjectMedia::factory()->image()->create();
    ProjectMedia::factory()->video()->create();

    $images = ProjectMedia::ofType('image')->get();

    expect($images)->toHaveCount(2);
});

it('scope ordered sorts by sort_order', function () {
    ProjectMedia::factory()->image()->create(['sort_order' => 3]);
    ProjectMedia::factory()->image()->create(['sort_order' => 1]);
    ProjectMedia::factory()->image()->create(['sort_order' => 2]);

    $ordered = ProjectMedia::ordered()->get();

    expect($ordered->first()->sort_order)->toBe(1)
        ->and($ordered->last()->sort_order)->toBe(3);
});

it('can store alt_text and caption', function () {
    $media = ProjectMedia::factory()->image()->create([
        'alt_text' => 'Project screenshot',
        'caption' => 'Homepage design',
    ]);

    expect($media->alt_text)->toBe('Project screenshot')
        ->and($media->caption)->toBe('Homepage design');
});

it('cascades delete when project is deleted', function () {
    $project = Project::factory()->create();
    ProjectMedia::factory()->count(2)->create(['project_id' => $project->id]);

    $project->delete();

    expect(ProjectMedia::where('project_id', $project->id)->count())->toBe(0);
});
