<?php

namespace Webbingbrasil\FilamentCopyActions\Concerns;

use Closure;
use Filament\Forms\Components\Field;
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

    public function getCopyableClickHandler(): Closure
    {
        return function ($component) {

            $writeText = 'event.currentTarget.dataset.copyable';
            if ($component instanceof Field) {
                $writeText .= ' ?? $wire.' .$component->getStatePath();
            }

            return new HtmlString(
                'window.navigator.clipboard.writeText('.$writeText.');'
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
