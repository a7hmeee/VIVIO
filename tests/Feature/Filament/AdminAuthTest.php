<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('redirects guests to the login page', function () {
    $this->get('/admin')
        ->assertRedirect('/admin/login');
});

it('shows the login page to guests', function () {
    $this->get('/admin/login')->assertSuccessful();
});

it('denies panel access to non-admin users', function () {
    $user = User::factory()->create(['is_admin' => false]);

    $this->actingAs($user)
        ->get('/admin')
        ->assertForbidden();
});

it('grants panel access to admin users', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get('/admin')
        ->assertSuccessful();
});

it('allows admins to log out of the panel', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)->post('/admin/logout');

    $this->assertGuest();
});
