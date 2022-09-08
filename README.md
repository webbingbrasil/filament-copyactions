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

### Table Action


```php
use Webbingbrasil\FilamentCopyActions\Tables\Actions\CopyAction;
$table
    ->actions([
        CopyAction::make()->copyable(fn ($record) => $record->name),
    ])
```

## Credits

-   [Danilo Andrade](https://github.com/dmandrade)

