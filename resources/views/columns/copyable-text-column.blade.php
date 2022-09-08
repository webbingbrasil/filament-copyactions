@php
    $state = $getFormattedState();
    $copyableText = $getCopyableText();
    $descriptionAbove = $getDescriptionAbove();
    $descriptionBelow = $getDescriptionBelow();
    $iconColor = $getIconColor();
    $success = $getSuccess();

    $icon = $getIcon();
    $iconPosition = $getIconPosition();
@endphp

<div
    {{ $attributes->merge($getExtraAttributes())->class([
        'px-4 py-3 filament-tables-text-column',
        'text-primary-600 transition hover:underline hover:text-primary-500 focus:underline focus:text-primary-500' => $getAction() || $getUrl(),
        'whitespace-normal' => $canWrap(),
    ]) }}
>
    @if (filled($state))
        <div @class([
        'inline-flex items-center justify-center space-x-1 rtl:space-x-reverse min-h-6 px-2 py-0.5 text-sm font-medium tracking-tight rounded-xl whitespace-normal',
        ])>
            @if ($icon && $iconPosition === 'before')
                <x-filament-copyactions::copy-button
                    :success="$success"
                    :content="$copyableText"
                    :iconColor="$iconColor"
                    :icon="$icon" />
            @endif

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

            @if ($icon && $iconPosition === 'after')
                <x-filament-copyactions::copy-button
                    :success="$success"
                    :content="$copyableText"
                    :iconColor="$iconColor"
                    :icon="$icon" />
            @endif
        </div>
    @endif
</div>
