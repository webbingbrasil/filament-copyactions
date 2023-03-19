<?php

namespace Webbingbrasil\FilamentCopyActions;

use Filament\Facades\Filament;
use Illuminate\Support\HtmlString;
use Webbingbrasil\FilamentCopyActions\Forms\Actions\CopyAction;
use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;

class FilamentCopyActionsProvider extends PluginServiceProvider
{
    protected array $beforeCoreScripts = [
        'ClipboardJS' => __DIR__.'/../resources/js/clipboard.min.js',
    ];

    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-copyactions')
            ->hasViews();
    }

    public function packageBooted(): void
    {
        Filament::registerRenderHook('scripts.end', fn () => new HtmlString("
            <script>
                document.addEventListener('clipboard', function (e) {
                    if (!window.navigator.clipboard) {
                        ClipboardJS.copy(e.detail);
                        return;
                    }

                    window.navigator.clipboard.writeText(e.detail)
                        .then(function() {})
                        .catch(function() {
                            ClipboardJS.copy(e.detail);
                        });
                });
            </script>
        "));

        CopyAction::configureUsing(fn (CopyAction $action) => $action->copyable(fn ($component) => $component->getState()));
    }
}
