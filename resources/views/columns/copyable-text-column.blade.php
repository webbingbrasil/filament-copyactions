@php
    $state = $getFormattedState();
    $copyableText = $getCopyableText();

    $descriptionAbove = $getDescriptionAbove();
    $descriptionBelow = $getDescriptionBelow();

    $icon = $getIcon();
    $iconPosition = $getIconPosition();
    $iconColor = $getIconColor();
    $iconClasses = 'w-4 h-4';

    $copyMessage = $getCopyMessage();
@endphp

<div
    {{ $attributes->merge($getExtraAttributes())->class([
        'filament-tables-text-column',
        'px-4 py-3' => ! $isInline(),
        'text-primary-600 transition hover:underline hover:text-primary-500 focus:underline focus:text-primary-500' => $getAction() || $getUrl(),
        match ($getColor()) {
            'danger' => 'text-danger-600',
            'primary' => 'text-primary-600',
            'secondary' => 'text-gray-500',
            'success' => 'text-success-600',
            'warning' => 'text-warning-600',
            default => null,
        } => ! ($getAction() || $getUrl()),
        match ($getColor()) {
            'secondary' => 'dark:text-gray-400',
            default => null,
        } => (! ($getAction() || $getUrl())) && config('tables.dark_mode'),
        match ($getSize()) {
            'sm' => 'text-sm',
            'lg' => 'text-lg',
            default => null,
        },
        match ($getWeight()) {
            'thin' => 'font-thin',
            'extralight' => 'font-extralight',
            'light' => 'font-light',
            'medium' => 'font-medium',
            'semibold' => 'font-semibold',
            'bold' => 'font-bold',
            'extrabold' => 'font-extrabold',
            'black' => 'font-black',
            default => null,
        },
        match ($getFontFamily()) {
            'sans' => 'font-sans',
            'serif' => 'font-serif',
            'mono' => 'font-mono',
            default => null,
        },
        'whitespace-normal' => $canWrap(),
    ]) }}
>
    @if (filled($state))
        <div @class([
            'inline-flex items-center space-x-1 rtl:space-x-reverse',
        ])>
            @if ($icon && $iconPosition === 'before')
                <x-filament-copyactions::copy-button
                    :success="$copyMessage"
                    :content="$copyableText"
                    :iconColor="$iconColor"
                    :icon="$icon" />
            @endif

            @if(! $isOnlyIcon())
                <div>
                    @if (filled($descriptionAbove))
                        <span class="block text-sm text-gray-400">
                            {{ $descriptionAbove instanceof \Illuminate\Support\HtmlString ? $descriptionAbove : \Illuminate\Support\Str::of($descriptionAbove)->markdown()->sanitizeHtml()->toHtmlString() }}
                        </span>
                    @endif

                    {{ $state }}

                    @if (filled($descriptionBelow))
                        <span class="block text-sm text-gray-400">
                            {{ $descriptionBelow instanceof \Illuminate\Support\HtmlString ? $descriptionBelow : \Illuminate\Support\Str::of($descriptionBelow)->markdown()->sanitizeHtml()->toHtmlString() }}
                        </span>
                    @endif
                </div>
            @endif

            @if ($icon && $iconPosition === 'after')
                <x-filament-copyactions::copy-button
                    :success="$copyMessage"
                    :content="$copyableText"
                    :iconColor="$iconColor"
                    :icon="$icon" />
            @endif
        </div>
    @endif
</div>
