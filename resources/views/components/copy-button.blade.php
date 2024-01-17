@props([
    'copyableState',
    'copyMessage',
    'copyMessageDuration',
    'icon' => 'heroicon-o-clipboard-copy',
    'iconClasses',
    'iconStyles',
])
@php
    $darkMode = config('filament.darkMode');
    $buttonClasses = [
        'flex items-center justify-center rounded-full hover:bg-gray-500/5 focus:outline-none filament-icon-button',
        'dark:hover:bg-gray-300/5' => $darkMode,
        'w-5 h-5'
    ];
@endphp

<button
    type="button"
    x-cloak
    x-data="{ clicked: false }"
    x-on:mouseover.outside="clicked = false"
    x-on:click.prevent="
        clicked = true;
        window.navigator.clipboard.writeText(@js($copyableState))
        $tooltip(@js($copyMessage), {
            theme: $store.theme,
            timeout: @js($copyMessageDuration),
        })
    "
    @class($buttonClasses)
>
    <x-filament::icon
        x-show="!clicked"
        :icon="$icon"
    />
    <x-filament::icon
        x-show="clicked"
        icon="heroicon-o-check"
    />
</button>
