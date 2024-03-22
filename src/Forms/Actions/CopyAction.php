<?php

namespace Webbingbrasil\FilamentCopyActions\Forms\Actions;

use Webbingbrasil\FilamentCopyActions\Concerns\HasCopyable;
use Filament\Forms\Components\Actions\Action as BaseAction;

class CopyAction extends BaseAction
{
    use HasCopyable {
        HasCopyable::getCopyable as getDefaultCopyable;
    }

    public function getCopyable(): ?string
    {
        if ($this->copyable === null) {
            return $this->evaluate(fn ($component) => '$wire.'.$component->getStatePath());
        }

        return $this->getDefaultCopyable();
    }
}
