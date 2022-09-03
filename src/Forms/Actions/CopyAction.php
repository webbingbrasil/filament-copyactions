<?php

namespace Webbingbrasil\FilamentCopyActions\Forms\Actions;

use Webbingbrasil\FilamentCopyActions\Concerns\HasCopyable;
use Filament\Forms\Components\Actions\Action as BaseAction;

class CopyAction extends BaseAction
{
    use HasCopyable;
}
