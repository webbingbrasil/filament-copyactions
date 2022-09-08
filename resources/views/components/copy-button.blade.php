@props([
    'content',
    'buttonColor',
    'success',
    'icon' => 'heroicon-o-clipboard-copy'
])
@php
    $darkMode = config('filament.darkMode');
    $buttonClasses = [
        'flex items-center justify-center rounded-full hover:bg-gray-500/5 focus:outline-none filament-icon-button',
        'text-primary-500 focus:bg-primary-500/10' => $buttonColor === 'primary',
        'text-danger-500 focus:bg-danger-500/10' => $buttonColor === 'danger',
        'text-gray-500 focus:bg-gray-500/10' => $buttonColor === 'secondary',
        'text-success-500 focus:bg-success-500/10' => $buttonColor === 'success',
        'text-warning-500 focus:bg-warning-500/10' => $buttonColor === 'warning',
        'dark:hover:bg-gray-300/5' => $darkMode,
        'w-8 h-8',
    ];
    $iconClasses = 'w-4 h-4';
@endphp

<button
    type="button"
    x-cloak
    x-data="{ clicked: false }"
    x-on:mouseover.outside="clicked = false"
    x-on:click.prevent="$dispatch('clipboard', '{{addslashes($content)}}'); clicked = true"
    @class($buttonClasses)
>
    <x-dynamic-component :component="$icon" :class="$iconClasses" x-show="!clicked"  />
    <x-heroicon-o-check x-show="clicked" @class([$iconClasses, 'text-success-500'])
    x-tooltip="{
        content: '{{ $success }}',
        placement: 'right',
        onHidden: () => { clicked = false ;}
    }"/>
</button>
