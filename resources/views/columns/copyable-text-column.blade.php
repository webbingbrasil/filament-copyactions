@php
    $state = $getFormattedState();
    $copyableText = $getCopyableText();
    $description = $getDescription();
    $descriptionPosition = $getDescriptionPosition();
    $buttonColor = $getButtonColor();

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
                    :content="$copyableText"
                    :buttonColor="$buttonColor"
                    :icon="$icon" />
            @endif

            <div>

                @if (filled($description) && $descriptionPosition === 'above')
                    <span class="block text-sm text-gray-400">
                        {{ $description instanceof \Illuminate\Support\HtmlString ? $description : \Illuminate\Support\Str::of($description)->markdown()->sanitizeHtml()->toHtmlString() }}
                    </span>
                @endif
                {{ $state }}

                @if (filled($description) && $descriptionPosition === 'below')
                    <span class="block text-sm text-gray-400">
                        {{ $description instanceof \Illuminate\Support\HtmlString ? $description : \Illuminate\Support\Str::of($description)->markdown()->sanitizeHtml()->toHtmlString() }}
                    </span>
                @endif
            </div>

            @if ($icon && $iconPosition === 'after')
                    <x-filament-copyactions::copy-button
                        :content="$copyableText"
                        :buttonColor="$buttonColor"
                        :icon="$icon" />
            @endif
        </div>
    @endif
</div>
