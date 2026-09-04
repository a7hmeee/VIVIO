<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Login as BaseLogin;

class Login extends BaseLogin
{
    public function getHeading(): string
    {
        return 'VIVIO ADMIN';
    }

    public function getSubheading(): string
    {
        return 'Sign in to the internal digital operating system.';
    }
}
