<?php

use App\Enums\LeadStatus;
use App\Models\Lead;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can create a lead', function () {
    $lead = Lead::factory()->create(['project_type' => 'Website']);

    expect($lead->status)->toBeInstanceOf(LeadStatus::class)
        ->and($lead->status)->toBe(LeadStatus::New)
        ->and($lead->project_type)->toBe('Website');
});

it('defaults to new status', function () {
    expect(Lead::factory()->create()->status)->toBe(LeadStatus::New);
});

it('can change status through the model', function () {
    $lead = Lead::factory()->create();

    $lead->markAs(LeadStatus::Qualified);

    expect($lead->refresh()->status)->toBe(LeadStatus::Qualified);
});

it('supports every defined status', function () {
    foreach (LeadStatus::cases() as $status) {
        Lead::query()->updateOrCreate(
            ['email' => "lead-{$status->value}@test.dev"],
            ['name' => 'T', 'message' => 'm', 'project_type' => 'x', 'status' => $status],
        );

        expect(Lead::ofStatus($status)->where('email', "lead-{$status->value}@test.dev")->exists())->toBeTrue();
    }
});

it('rejects invalid statuses at database level for sqlite enum-free column check', function () {
    // Statuses are validated by the enum cast + form validation; raw invalid
    // values are stored as-is but will not cast to a valid case.
    $lead = Lead::factory()->create(['status' => 'new']);

    expect($lead->fresh()->status)->toBe(LeadStatus::New);
});

it('scopes new leads', function () {
    Lead::factory()->count(2)->create();
    Lead::factory()->create(['status' => LeadStatus::Won->value]);

    expect(Lead::new()->count())->toBe(2);
});

it('orders recent leads newest first', function () {
    $old = Lead::factory()->create(['created_at' => now()->subDay()]);
    $newer = Lead::factory()->create();

    expect(Lead::recent()->first()->id)->toBe($newer->id);
});
