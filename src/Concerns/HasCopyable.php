<?php

namespace Webbingbrasil\FilamentCopyActions\Concerns;

use Closure;

trait HasCopyable
{
    protected Closure | string | null $copyable = null;

    public function setUp(): void
    {
        $this
            ->successNotificationMessage(__('Copied to clipboard'))
            ->failureNotificationMessage(__('No data to copy'))
            ->icon('heroicon-o-clipboard-copy')
            ->action(function (): void {
                $this->sendToClipboard() ? $this->success() : $this->failure();
            });
    }

    public function copyable(Closure | string | null $copyable): self
    {
        $this->copyable = $copyable;

        return $this;
    }

    public function getCopyable(): ?string
    {
        return $this->evaluate($this->copyable);
    }

    protected function sendToClipboard(): bool
    {
        $copy = $this->getCopyable();
        if (empty($copy)) {
            return false;
        }

        /** @var \Livewire\Component $livewire */
        $livewire = $this->getLivewire();
        $livewire->dispatchBrowserEvent('clipboard', $copy);

        return true;
    }
}
