<?php

namespace Webbingbrasil\FilamentCopyActions;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentCopyActionsProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-copyactions')
            ->hasViews();
    }
}
