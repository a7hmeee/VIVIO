<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Filament\Panel;
use Illuminate\Contracts\Support\Htmlable;

class Dashboard extends Page
{
    protected static ?string $title = 'Dashboard';

    protected static ?string $navigationLabel = 'Dashboard';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-home';

    protected static ?int $navigationSort = -2;

    protected static string $routePath = '/';

    protected string $view = 'filament.pages.dashboard';

    public static function getRoutePath(Panel $panel): string
    {
        return static::$routePath;
    }

    public function getHeading(): string|Htmlable|null
    {
        // The editorial hero composition replaces the native page header.
        return null;
    }

    public function getSubheading(): string|Htmlable|null
    {
        return null;
    }
}
