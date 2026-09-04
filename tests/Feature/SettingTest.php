<?php

use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('writes and reads settings', function () {
    Setting::set('site_name', 'VIVIO');

    expect(Setting::get('site_name'))->toBe('VIVIO');
});

it('returns default when key missing', function () {
    expect(Setting::get('nonexistent', 'fallback'))->toBe('fallback')
        ->and(Setting::get('nonexistent'))->toBeNull();
});

it('updates existing keys without duplicating rows', function () {
    Setting::set('contact_email', 'a@vivio.studio');
    Setting::set('contact_email', 'hello@vivio.studio');

    expect(Setting::get('contact_email'))->toBe('hello@vivio.studio')
        ->and(Setting::where('key', 'contact_email')->count())->toBe(1);
});

it('flushes cache when a setting is saved directly', function () {
    Setting::set('phone', '0500000000');

    Setting::where('key', 'phone')->update(['value' => '0511111111']);
    Cache::forget(Setting::CACHE_KEY);

    expect(Setting::get('phone'))->toBe('0511111111');
});
