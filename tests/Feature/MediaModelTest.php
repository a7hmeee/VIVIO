<?php

use App\Models\Media;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can create media records', function () {
    $media = Media::factory()->image()->create(['name' => 'Hero asset']);

    expect($media->name)->toBe('Hero asset')
        ->and($media->isImage())->toBeTrue();
});

it('supports all types', function () {
    Media::factory()->image()->create();
    Media::factory()->video()->create();
    Media::factory()->document()->create();

    expect(Media::count())->toBe(3)
        ->and(Media::ofType('video')->count())->toBe(1);
});

it('formats human readable size', function () {
    $media = Media::factory()->make(['size' => 1_572_864]);

    expect($media->human_size)->toBe('1.5 MB');
});

it('builds public storage url', function () {
    $media = Media::factory()->make(['file_path' => 'media/test.jpg']);

    expect($media->url)->toContain('/storage/media/test.jpg');
});

it('tracks uploader and survives user deletion via null', function () {
    $user = User::factory()->create();
    $media = Media::factory()->create(['uploaded_by' => $user->id]);

    expect($media->uploadedBy->id)->toBe($user->id);

    $media->uploadedBy->delete();
    $media->refresh();

    expect($media->uploaded_by)->toBeNull();
});
