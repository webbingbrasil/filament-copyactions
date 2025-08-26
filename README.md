# Filament Copy Actions

> **Note**
> For **Filament 3.x** use **[3.x](https://github.com/webbingbrasil/filament-copyactions/tree/3.x)** branch
> For **Filament 2.x** use **[2.x](https://github.com/webbingbrasil/filament-copyactions/tree/2.x)** branch

An easy-to-use copy actions for Filament Admin

- Table action to implement dynamic copy content
- Form action to use with any field
- Page action to implement a dynamic copy button on any page
- Custom copy table column to simply copy text content

> **Note**
> The copy will only work if the user browser supports [Clipboard API](https://developer.mozilla.org/en-US/docs/Web/API/Clipboard_API). Also, the user must be on a secure context (HTTPS) or localhost.


## Installation

```bash
composer require webbingbrasil/filament-copyactions
```

## Usage

### Table Column

Display a table text column with a copy button. The column has all features of the [TextColumn](https://filamentphp.com/docs/4.x/tables/columns/text) and the copy action sends column content to the clipboard and displays a success tooltip.

> **Note**
> Since Filament v3, there is a native feature to copy column content to clipboard (see [documentation](https://filamentphp.com/docs/4.x/tables/columns/text#allowing-the-text-to-be-copied-to-the-clipboard)). This custom column is maintained for compatibility and as a shortcut to implement copy functionality.


```php
use Webbingbrasil\FilamentCopyActions\Tables\CopyableTextColumn;

CopyableTextColumn::make('brand.name')
    ->copyMessage('Brand copied to clipboard')
    ->searchable()
    ->sortable()
    ->toggleable()
```

The column has an option to display a description above or below the text, by default this description is not copied, if you want to copy the description too, use the `copyWithDescription` method.

#### Success message

You can customize the success message with the `copyMessage` method, the default message is `Copied!`.

#### Icon Position and Color

You can customize the icon with the `icon`, `iconPosition` and `iconColor` methods.

## Using the CopyAction

The package provides a single action class `Webbingbrasil\FilamentCopyActions\Actions\CopyAction` that can be used across different contexts in your Filament application:

- As a Page Action to add copy functionality to any page
- As a Table Action to copy data from table records 
- As a Form Action to copy field values (algo in Placeholder)
- InfoList, TextEntry, Entry...

This unified approach simplifies usage while maintaining consistent behavior across your application. The action inherits all customization options from Filament's base Action class.


> **Important**
> The value set in `copyable()` is evaluated and stored in the HTML element's `data-copyable` attribute. For complex data, you must ensure the value is properly converted to a string and escaped, as unescaped values can break the page. For form fields, by default the copy function will use the field's state.


### Table Action

Display a table action button, you set the content using the `copyable` method. You can customize the button icon/color using the same methods of the [Filament Action](https://filamentphp.com/docs/2.x/tables/actions#setting-a-color).

```php
use Webbingbrasil\FilamentCopyActions\Actions\CopyAction;

$table
    ->actions([
        CopyAction::make()->copyable(fn ($record) => $record->name),
    ])
```

#### Success message

The action will display a copy status, you can customize the success message with the `successNotificationMessage` method or the error message with the `errorNotificationMessage` method.


### Form Action

Use the `CopyAction` in your field suffix or prefix if you want to copy a field value. You can customize the button icon/color using the same methods of the [Filament Action](https://filamentphp.com/docs/2.x/tables/actions#setting-a-color).

```php
use Webbingbrasil\FilamentCopyActions\Actions\CopyAction;

Forms\Components\TextInput::make('sku')
    ->label('SKU (Stock Keeping Unit)')
    ->suffixAction(CopyAction::make())
    ->required();
    
Forms\Components\Select::make('shop_brand_id')
    ->relationship('brand', 'name')
    ->prefixAction(CopyAction::make())
    ->searchable();
```

You can use this form action in any filament field, the action will copy the field value to the clipboard by default, but you can customize the value with the `copyable` method.


```php
use Webbingbrasil\FilamentCopyActions\Actions\CopyAction;

Forms\Components\Select::make('shop_brand_id')
    ->relationship('brand', 'name')
    ->prefixAction(CopyAction::make()->copyable(fn ($component) => $component->getOptionLabel()))
    ->searchable();
```

#### Success message

The action will display a copy status, you can customize the success message with the `successNotificationMessage` method or the error message with the `errorNotificationMessage` method.

### Page Action

You can add `CopyAction` button to any page in filament, just put the action in the `actions` method of the page. You can customize the button icon/color using the same methods of the [Filament Action](https://filamentphp.com/docs/2.x/tables/actions#setting-a-color).

```php
use Webbingbrasil\FilamentCopyActions\Pages\Actions\CopyAction;

protected function getActions(): array
{
    return [
        CopyAction::make()->copyable(fn () => $this->record->name),
    ];
}
```

The action will display a copy status, you can customize the success message with the `successNotificationMessage` method or the error message with the `errorNotificationMessage` method.

### CopyAction Tip

By default, CopyAction does not trigger a livewire request, so it only returns the value defined in the copyable method during page rendering.

However, if it is necessary for the copied value to be dynamic at each action trigger, you can use the `action()` method.

```php
CopyAction::make()->copyable(fn () => $this->voucher)->action(fn() => $this->generateVoucher()),
```

You can use this technique in actions for form, pages, or tables.

## Credits

-   [Danilo Andrade](https://github.com/dmandrade)
