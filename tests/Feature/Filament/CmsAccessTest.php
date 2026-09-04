<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('blocks guests from every cms resource', function (string $path) {
    $this->get("/admin/{$path}")->assertRedirect('/admin/login');
})->with([
    ['projects'],
    ['categories'],
    ['articles'],
    ['article-categories'],
    ['clients'],
    ['testimonials'],
    ['media'],
    ['leads'],
    ['manage-settings'],
]);

it('blocks non-admin users from every cms resource', function (string $path) {
    $user = User::factory()->create(['is_admin' => false]);

    $this->actingAs($user)->get("/admin/{$path}")->assertForbidden();
})->with([
    ['projects'],
    ['articles'],
    ['clients'],
    ['testimonials'],
    ['media'],
    ['leads'],
    ['manage-settings'],
]);

it('allows admins to access every cms resource', function (string $path) {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)->get("/admin/{$path}")->assertSuccessful();
})->with([
    ['projects'],
    ['categories'],
    ['articles'],
    ['article-categories'],
    ['clients'],
    ['testimonials'],
    ['media'],
    ['leads'],
    ['manage-settings'],
]);

it('renders the vivio control center dashboard for admins', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get('/admin')
        ->assertSuccessful()
        ->assertSee('VIVIO');
});
