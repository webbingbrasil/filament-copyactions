<?php

namespace Webbingbrasil\FilamentCopyActions\Concerns;

use Closure;
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
            ->dispatch('FilamentCopyActions')
            ->successNotificationTitle(__('Copied!'))
            ->icon('heroicon-o-clipboard-document')
            ->extraAttributes(fn () => [
                'x-data' => '',
                'x-on:click' => new HtmlString(
                    'window.navigator.clipboard.writeText('.$this->getCopyable().');'
                    . (($title = $this->getSuccessNotificationTitle()) ? ' $tooltip('.Js::from($title).');' : '')
                ),
            ]);
    }

    public function action(Closure | string | null $action): static
    {
        $this->dispatch(null);
        return parent::action($action);
    }

    public function copyable(Closure | string | null $copyable): self
    {
        $this->copyable = $copyable;

        return $this;
    }

    public function getCopyable(): ?string
    {
        return JS::from($this->evaluate($this->copyable));
    }
}
