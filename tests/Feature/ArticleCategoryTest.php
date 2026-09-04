<?php

use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can create an article category', function () {
    $category = ArticleCategory::factory()->create(['name' => 'Insights']);

    expect($category->name)->toBe('Insights');
});

it('auto generates slug from name', function () {
    $category = ArticleCategory::factory()->create(['name' => 'Case Notes', 'slug' => '']);

    expect($category->refresh()->slug)->toBe('case-notes');
});

it('has unique slugs', function () {
    ArticleCategory::factory()->create(['slug' => 'notes']);

    ArticleCategory::factory()->create(['slug' => 'notes']);
})->throws(QueryException::class);

it('can have many articles', function () {
    $category = ArticleCategory::factory()->create();

    Article::factory()->count(3)->create(['category_id' => $category->id]);

    expect($category->articles)->toHaveCount(3);
});

it('counts published articles separately', function () {
    $category = ArticleCategory::factory()->create();

    Article::factory()->published()->create(['category_id' => $category->id]);
    Article::factory()->draft()->create(['category_id' => $category->id]);

    expect($category->publishedArticles)->toHaveCount(1);
});
