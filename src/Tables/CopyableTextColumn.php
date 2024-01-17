<?php

namespace Webbingbrasil\FilamentCopyActions\Tables;

use Closure;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;

class CopyableTextColumn extends TextColumn
{
    protected string $view = 'filament-copyactions::columns.copyable-text-column';

    protected string | bool | Closure | null $icon = 'heroicon-o-clipboard-document';

    protected bool | Closure $copyWithDescription = false;

    protected bool | Closure $isOnlyIcon = false;

    public function setUp(): void
    {
        $this
            ->disabledClick(fn ($livewire) => is_a($livewire, RelationManager::class))
            ->copyableState(function ($state) {
                $copyDescription = (bool) $this->evaluate($this->copyWithDescription);
                if ($copyDescription) {
                    $state = implode("\r\n", array_filter([
                        $this->getDescriptionAbove(),
                        $state,
                        $this->getDescriptionBelow(),
                    ]));
                }

                return $state;
            });
    }

    public function onlyIcon(bool | Closure $isOnlyIcon = true): static
    {
        $this->isOnlyIcon = $isOnlyIcon;

        return $this;
    }

    public function isOnlyIcon(): bool
    {
        return $this->evaluate($this->isOnlyIcon);
    }

    public function copyWithDescription(bool | Closure $copyWithDescription = true): self
    {
        $this->copyWithDescription = $copyWithDescription;

        return $this;
    }
}
