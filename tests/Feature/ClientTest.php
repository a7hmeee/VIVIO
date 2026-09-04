<?php

use App\Models\Client;
use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can create a client', function () {
    $client = Client::factory()->create(['name' => 'Acme Corp']);

    expect($client->name)->toBe('Acme Corp')
        ->and($client->is_featured)->toBeFalse();
});

it('can be featured', function () {
    $client = Client::factory()->featured()->create();

    expect($client->is_featured)->toBeTrue()
        ->and(Client::featured()->count())->toBe(1);
});

it('orders by sort order then name', function () {
    Client::factory()->create(['name' => 'Zeta', 'sort_order' => 3]);
    Client::factory()->create(['name' => 'Alpha', 'sort_order' => 1]);
    Client::factory()->create(['name' => 'Beta', 'sort_order' => 2]);
    Client::factory()->create(['name' => 'Gamma', 'sort_order' => 4]);

    $ordered = Client::ordered()->pluck('name');

    expect($ordered->first())->toBe('Alpha')
        ->and($ordered->get(1))->toBe('Beta')
        ->and($ordered->last())->toBe('Gamma');
});

it('breaks sort order ties alphabetically', function () {
    Client::factory()->create(['name' => 'Zeta', 'sort_order' => 0]);
    Client::factory()->create(['name' => 'Alpha', 'sort_order' => 0]);

    expect(Client::ordered()->first()->name)->toBe('Alpha');
});

it('can have testimonials', function () {
    $client = Client::factory()->create();

    Testimonial::factory()->count(2)->create(['client_id' => $client->id]);

    expect($client->testimonials)->toHaveCount(2);
});
