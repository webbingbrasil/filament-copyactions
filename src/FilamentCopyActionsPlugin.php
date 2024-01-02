<?php

namespace Webbingbrasil\FilamentCopyActions;

use Filament\Facades\Filament;
use Illuminate\Support\HtmlString;
use Webbingbrasil\FilamentCopyActions\Forms\Actions\CopyAction;
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
        CopyAction::configureUsing(fn (CopyAction $action) => $action->copyable(fn ($component) => $component->getState()));
    }
}
