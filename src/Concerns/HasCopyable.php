<?php

namespace Webbingbrasil\FilamentCopyActions\Concerns;

use Closure;
use Filament\Forms\Components\Field;
use Filament\Infolists\Components\Entry;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Js;

trait HasCopyable
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
            if ($component instanceof Field) {
                $writeText = '$state';
            }
            if ($component instanceof Entry) {
                $writeText = Js::from($component->getState());
            }

            return new HtmlString(
                "console.log('ok');".
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
