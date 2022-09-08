# Filament Copy Actions

A easy-to-use copy actions for Filament Admin

- Table action to implement dynamic copy content
- Form action to use with any field
- Page action to implement dynamic copy button in any page
- Custom copy table column to simple copy text content

## Installation

```bash
composer require webbingbrasil/filament-copyactions
```

## Usage

### Table Column

Display a table text column with a copy button, the column has all features of the [TextColumn](https://filamentphp.com/docs/2.x/tables/columns#text-column) and the copy action send column content to clipboard and display a success tooltip

```php
use Webbingbrasil\FilamentCopyActions\Tables\CopyableTextColumn;

CopyableTextColumn::make('brand.name')
    ->successMessage('Brand copied to clipboard')
    ->searchable()
    ->sortable()
    ->toggleable(),
```

You can customize the success message with the `successMessage` method, the default message is `Copied!`

The column has a option to display a description above ou below the text, by default this description is not copied, if you want to copy the description too, use the `copyWithDescription` method


### Table Action

Display a table action button, you set the content using `copyable` method.

```php
use Webbingbrasil\FilamentCopyActions\Tables\Actions\CopyAction;

$table
    ->actions([
        CopyAction::make()->copyable(fn ($record) => $record->name),
    ])
```

The action will display a copy status, you can customize the success message with the `successNotificationMessage` method or the error message with the `errorNotificationMessage` method.

### Form Action

If you want to copy a field value, use the `CopyAction` in your field suffix or prefix.

```php
use Webbingbrasil\FilamentCopyActions\Forms\Actions\CopyAction;

Forms\Components\TextInput::make('sku')
    ->label('SKU (Stock Keeping Unit)')
    ->suffixAction(CopyAction::make())
    ->required();
    
Forms\Components\Select::make('shop_brand_id')
    ->relationship('brand', 'name')
    ->prefixAction(\Webbingbrasil\FilamentCopyActions\Forms\Actions\CopyAction::make())
    ->searchable();
```

You can use this form action in any filament field, the action will copy the field value to clipboard by default, but you can customize the value with the `copyable` method

The action will display a copy status, you can customize the success message with the `successNotificationMessage` method or the error message with the `errorNotificationMessage` method.

```php

Forms\Components\Select::make('shop_brand_id')
    ->relationship('brand', 'name')
    ->prefixAction(\Webbingbrasil\FilamentCopyActions\Forms\Actions\CopyAction::make()->copyable(fn ($component) => $component->getOptionLabel()))
    ->searchable();
```

### Page Action

You can add `CopyAction` buttom to any page in filament, just put the action in the `actions` method of the page. 

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

```php

## Credits

-   [Danilo Andrade](https://github.com/dmandrade)

