<?php

use App\Models\Category;
use App\Models\Project;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can create a category', function () {
    $category = Category::factory()->create();

    expect($category)->toBeInstanceOf(Category::class)
        ->and($category->name)->not->toBeEmpty()
        ->and($category->slug)->not->toBeEmpty()
        ->and($category->description)->not->toBeEmpty();
});

it('auto generates slug from name', function () {
    $category = Category::factory()->create([
        'name' => 'Web Development',
        'slug' => '',
    ]);

    expect($category->slug)->toBe('web-development');
});

it('updates slug when name changes', function () {
    $category = Category::factory()->create(['name' => 'Original Name']);

    $category->update(['name' => 'New Name']);

    expect($category->slug)->toBe('new-name');
});

it('has unique slug constraint', function () {
    Category::factory()->create(['slug' => 'design']);

    Category::factory()->create(['slug' => 'design']);
})->throws(QueryException::class);

it('can have many projects', function () {
    $category = Category::factory()->create();

    $category->projects()->saveMany([
        Project::factory()->make(),
        Project::factory()->make(),
    ]);

    expect($category->projects)->toHaveCount(2);
});

it('can get published projects only', function () {
    $category = Category::factory()->create();

    Project::factory()->published()->create(['category_id' => $category->id]);
    Project::factory()->published()->create(['category_id' => $category->id]);
    Project::factory()->unpublished()->create(['category_id' => $category->id]);

    expect($category->publishedProjects)->toHaveCount(2);
});

it('uses slug as route key name', function () {
    $category = Category::factory()->create(['slug' => 'ui-ux']);

    $found = Category::where('slug', 'ui-ux')->first();

    expect($found->slug)->toBe('ui-ux');
});

it('can serialize to array', function () {
    $category = Category::factory()->create();

    $array = $category->toArray();

    expect($array)->toHaveKeys(['id', 'name', 'slug', 'description', 'created_at', 'updated_at']);
});
