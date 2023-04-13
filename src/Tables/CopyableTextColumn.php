<?php

namespace Webbingbrasil\FilamentCopyActions\Tables;

use Closure;
use Filament\Tables\Columns\TextColumn;

class CopyableTextColumn extends TextColumn
{
    protected string | Closure | null $icon = 'heroicon-o-clipboard-copy';

    protected string | Closure | null $copyIconColor = null;

    protected string | Closure | null $iconPosition = null;

    protected bool | Closure $copyWithDescription = false;

    protected string | Closure | null $successNotificationMessage = 'Copied!';

    protected string $view = 'filament-copyactions::columns.copyable-text-column';

    protected bool | Closure $isOnlyIcon = false;

    public function onlyIcon(bool | Closure $isOnlyIcon = true): static
    {
        $this->isOnlyIcon = $isOnlyIcon;

        return $this;
    }

    public function isOnlyIcon(): bool
    {
        return $this->evaluate($this->isOnlyIcon);
    }

    public function successMessage(string | Closure | null $message): static
    {
        $this->successNotificationMessage = $message;

        return $this;
    }

    public function getSuccess(): string
    {
        return $this->evaluate($this->successNotificationMessage);
    }

    public function getCopyableText(): ?string
    {
        $state = $this->getFormattedState();
        $copyDescription = (bool) $this->evaluate($this->copyWithDescription);
        if ($copyDescription) {
            $state = implode("\r\n", array_filter([
                $this->getDescriptionAbove(),
                $state,
                $this->getDescriptionBelow(),
            ]));
        }

        return $state;
    }

    public function copyWithDescription(bool | Closure $copyWithDescription = true): self
    {
        $this->copyWithDescription = $copyWithDescription;

        return $this;
    }

    public function iconColor(string | Closure $copyIconColor): static
    {
        $this->copyIconColor = $copyIconColor;

        return $this;
    }

    public function getIconColor(): ?string
    {
        return $this->evaluate($this->copyIconColor);
    }
}
