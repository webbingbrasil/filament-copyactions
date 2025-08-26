<?php

namespace Webbingbrasil\FilamentCopyActions\Tables;

use Closure;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use BackedEnum;

class CopyableTextColumn extends TextColumn
{
    protected bool | Closure $copyWithDescription = false;

    public function setUp(): void
    {
        $this
            ->copyable(true)
            ->icon('heroicon-o-clipboard-document')
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

    /**
     * @deprecated To maintain maximum compatibility with Filament 4.x native TextColumn, this method is deprecated.
     * Use CopyAction instead.
     */
    public function onlyIcon(bool | Closure $isOnlyIcon = true): static
    {
        return $this;
    }

    public function copyWithDescription(bool | Closure $copyWithDescription = true): self
    {
        $this->copyWithDescription = $copyWithDescription;

        return $this;
    }
}
