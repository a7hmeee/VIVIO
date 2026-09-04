<?php

use App\Filament\Resources\Categories\Pages\ManageCategories;
use App\Models\Category;
use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->actingAs(User::factory()->admin()->create());
});

it('renders the categories list page', function () {
    Livewire::test(ManageCategories::class)->assertSuccessful();
});

it('lists categories in the table', function () {
    $category = Category::factory()->create(['name' => 'Web Design']);

    Livewire::test(ManageCategories::class)
        ->assertSee('Web Design')
        ->assertCanSeeTableRecords([$category]);
});

it('can create a category through the admin form', function () {
    Livewire::test(ManageCategories::class)
        ->callAction('create', data: [
            'name' => 'Branding',
            'slug' => 'branding',
            'description' => 'Brand identity work.',
        ])
        ->assertHasNoActionErrors();

    expect(Category::where('slug', 'branding')->exists())->toBeTrue();
});

it('validates required fields when creating a category', function () {
    Livewire::test(ManageCategories::class)
        ->callAction('create', data: ['name' => null])
        ->assertHasActionErrors(['name']);
});

it('rejects duplicate slugs', function () {
    Category::factory()->create(['slug' => 'design']);

    Livewire::test(ManageCategories::class)
        ->callAction('create', data: [
            'name' => 'Another',
            'slug' => 'design',
        ])
        ->assertHasActionErrors(['slug']);
});

it('can edit a category through the admin table action', function () {
    $category = Category::factory()->create(['name' => 'Old Name']);

    Livewire::test(ManageCategories::class)
        ->callAction(
            TestAction::make('edit')->table($category),
            data: ['name' => 'New Name', 'slug' => 'new-name'],
        )
        ->assertHasNoActionErrors();

    expect($category->refresh()->name)->toBe('New Name');
});

it('can delete a category through the admin table action', function () {
    $category = Category::factory()->create();

    Livewire::test(ManageCategories::class)
        ->callAction(TestAction::make('delete')->table($category));

    expect(Category::find($category->id))->toBeNull();
});

it('searches categories by name', function () {
    Category::factory()->create(['name' => 'Alpha Design']);
    Category::factory()->create(['name' => 'Beta Motion']);

    Livewire::test(ManageCategories::class)
        ->searchTable('Alpha')
        ->assertSee('Alpha Design')
        ->assertDontSee('Beta Motion');
});
