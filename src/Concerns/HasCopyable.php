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
            ->successNotificationTitle(__('Copied!'))
            ->icon('heroicon-o-clipboard-copy')
            ->extraAttributes(fn () => [
                'x-data' => new HtmlString(Js::from([
                    'copyable' => $this->getCopyable(),
                    'successMessage' => $this->getSuccessNotificationTitle(),
                ])),
                'x-on:click' => 'window.navigator.clipboard.writeText(copyable); $tooltip(successMessage);'
            ]);
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
}
