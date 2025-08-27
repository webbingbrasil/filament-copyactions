<?php

namespace Webbingbrasil\FilamentCopyActions\Actions;

use Closure;
use Filament\Actions\Action;
use Filament\Schemas\Components\Component;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Js;

class CopyAction extends Action
{
    protected Closure | string | null $copyable = null;

    public static function getDefaultName(): ?string
    {
        return 'copy';
    }

    public function setUp(): void
    {
        parent::setUp();

        $this
            ->alpineClickHandler($this->getCopyableClickHandler())
            ->successNotificationTitle(__('Copied!'))
            ->icon('heroicon-o-clipboard-document');
    }

    public function action(Closure | string | null $action): static
    {
        parent::action($action);
        $this->livewireClickHandlerEnabled(true);
        return $this;
    }

    public function getCopyableClickHandler(): Closure
    {
        return function ($component) {

            $writeText = 'event.currentTarget.dataset.copyable';
            if ($component instanceof Component) {
                $writeText = '$state';
            }

            return new HtmlString(
                "window.navigator.clipboard.writeText(".$writeText.");"
                . (($title = $this->getSuccessNotificationTitle()) ? ' $tooltip('.Js::from($title).');' : '')
            );
        };
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

    public function toHtml(): string
    {
        $this->extraAttributes([
            'data-copyable' => $this->getCopyable(),
        ], true);

        return parent::toHtml();
    }
}
