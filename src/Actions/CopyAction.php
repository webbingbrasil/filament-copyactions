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
        return function (array $arguments, $component) {

            $writeText = 'event.currentTarget.dataset.copyable';
            if ($component instanceof Component && $this->copyable === null) {
                $writeText = '$state';
                if (isset($arguments['item'])) {
                    $writeText .= '['.Js::from($arguments['item']).']';
                }
            }

            return new HtmlString(
                "((t)=>window.navigator.clipboard.writeText("
  . "(typeof t==='object'&&t?Object.entries({...t}).map(([k,v])=>k+': '+(v==null?'null':(typeof v==='object'?JSON.stringify(v):String(v)))).join('\\r\\n'):String(t)"
  . ")))(" . $writeText . ");"
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
