<?php

namespace Webbingbrasil\FilamentCopyActions;

use Filament\Contracts\Plugin;
use Filament\Panel;

class FilamentCopyActionsPlugin implements Plugin
{
    public static function make(): static
    {
        return app(static::class);
    }

    public function getId(): string
    {
        return 'filament-copyactions';
    }

    public function register(Panel $panel): void
    {
        //
    }

    public function boot(Panel $panel): void
    {
    }
}
