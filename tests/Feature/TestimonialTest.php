<?php

use App\Models\Client;
use App\Models\Project;
use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can create a testimonial', function () {
    $testimonial = Testimonial::factory()->create();

    expect($testimonial->quote)->not->toBeEmpty()
        ->and($testimonial->is_published)->toBeFalse();
});

it('optionally links to a client', function () {
    $client = Client::factory()->create();

    $linked = Testimonial::factory()->create(['client_id' => $client->id]);
    $unlinked = Testimonial::factory()->create(['client_id' => null]);

    expect($linked->client->id)->toBe($client->id)
        ->and($unlinked->client)->toBeNull();
});

it('optionally links to a project', function () {
    $project = Project::factory()->create();

    $testimonial = Testimonial::factory()->create(['project_id' => $project->id]);

    expect($testimonial->project->id)->toBe($project->id);
});

it('scope published filters visibility', function () {
    Testimonial::factory()->published()->create();
    Testimonial::factory()->create();

    expect(Testimonial::published()->count())->toBe(1);
});

it('builds attribution string', function () {
    $full = Testimonial::factory()->make([
        'client_name' => 'Sara Al-Rashid',
        'position' => 'CMO',
        'company' => 'Acme',
    ]);

    $minimal = Testimonial::factory()->make([
        'client_name' => 'Omar',
        'company' => null,
        'position' => null,
    ]);

    expect($full->attribution)->toBe('Sara Al-Rashid, CMO, Acme')
        ->and($minimal->attribution)->toBe('Omar');
});
