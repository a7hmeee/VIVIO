<?php

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can create an article', function () {
    $article = Article::factory()->create(['title' => 'Design Systems in Arabic']);

    expect($article)->toBeInstanceOf(Article::class)
        ->and($article->title)->toBe('Design Systems in Arabic');
});

it('auto generates slug from title', function () {
    $article = Article::factory()->create(['title' => 'New Editorial Wave', 'slug' => '']);

    expect($article->refresh()->slug)->toBe('new-editorial-wave');
});

it('has unique slugs', function () {
    Article::factory()->create(['slug' => 'same-slug']);

    Article::factory()->create(['slug' => 'same-slug']);
})->throws(QueryException::class);

it('belongs to an author', function () {
    $article = Article::factory()->create();

    expect($article->author)->toBeInstanceOf(User::class);
});

it('optionally belongs to a category', function () {
    $with = Article::factory()->create();
    $without = Article::factory()->create(['category_id' => null]);

    expect($with->category)->toBeInstanceOf(ArticleCategory::class)
        ->and($without->category)->toBeNull();
});

it('scope published returns only live articles', function () {
    Article::factory()->published()->create();
    Article::factory()->draft()->create();

    expect(Article::published()->count())->toBe(1);
});

it('scope published excludes scheduled articles', function () {
    Article::factory()->scheduled()->create();

    expect(Article::published()->count())->toBe(0)
        ->and(Article::draft()->count())->toBe(1);
});

it('scope latestPublished orders by published date', function () {
    $old = Article::factory()->published()->create(['published_at' => now()->subDays(5)]);
    $new = Article::factory()->published()->create(['published_at' => now()]);

    expect(Article::latestPublished()->first()->id)->toBe($new->id)
        ->and(Article::latestPublished()->count())->toBeLessThanOrEqual(10)
        ->and($old->published_at->isPast())->toBeTrue();
});
