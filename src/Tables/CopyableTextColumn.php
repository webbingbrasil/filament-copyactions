<?php

namespace Webbingbrasil\FilamentCopyActions\Tables;

use Closure;
use Filament\Tables\Columns\TextColumn;

class CopyableTextColumn extends TextColumn
{
    protected string | Closure | null $icon = 'heroicon-o-clipboard-copy';

    protected string | Closure | null $copyButtonColor = null;

    protected string | Closure | null $iconPosition = null;

    protected bool | Closure $copyWithDescription = false;

    protected string $view = 'filament-copyactions::columns.copyable-text-column';

    public function getCopyableText(): string
    {
        $state = $this->getFormattedState();
        $copyDescription = (bool) $this->evaluate($this->copyWithDescription);
        if ($copyDescription) {
            $description = $this->getDescription();
            $descriptionPosition = $this->getDescriptionPosition();

            return implode('\r\n', array_filter([
                filled($description) && $descriptionPosition === 'above' ? $description : '',
                $state,
                filled($description) && $descriptionPosition === 'below' ? $description : '',
            ]));
        }

        return $state;
    }

    public function copyWithDescription(bool | Closure $copyWithDescription = true): self
    {
        $this->copyWithDescription = $copyWithDescription;

        return $this;
    }

    public function icon(string | Closure $icon): static
    {
        $this->icon = $icon;

        return $this;
    }

    public function buttonColor(string | Closure $copyButtonColor): static
    {
        $this->copyButtonColor = $copyButtonColor;

        return $this;
    }

    public function getButtonColor(): ?string
    {
        return $this->evaluate($this->copyButtonColor);
    }

    public function getIcon(): string
    {
        return $this->evaluate($this->icon);
    }

    public function getIconPosition(): string
    {
        return $this->evaluate($this->iconPosition) ?? 'before';
    }
}
