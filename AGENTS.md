# Development Guidelines for Agents

## Foundational Context
This application is a Laravel application running on PHP 8.5 (compatible with PHP 8.3+).
Always use APIs and syntax that match the installed versions:
- Confirm PHP package versions with `composer show --direct`.
- Confirm JS package versions with `package.json`.

## Coding Conventions
- Follow all existing Laravel idioms and project structure.
- Always use curly braces for control structures.
- Use PHP 8 constructor property promotion.
- Use explicit return type declarations and type hints for method parameters.
- Use TitleCase for Enum keys.
- Prefer PHPDoc blocks over inline comments.

## Artisan & Laravel Patterns
- Use `php artisan make:` commands with `--no-interaction` to create new files (controllers, models, migrations, etc.).
- Default to using Eloquent API Resources for API responses.
- Use named routes and the `route()` helper when generating URLs.

## Code Quality & Formatter (Laravel Pint)
- Run `vendor/bin/pint --dirty` before finalizing changes to ensure compliance with styling rules.

## Testing (PHPUnit)
- Create tests with `php artisan make:test --phpunit {name}`.
- Run tests with `php artisan test --compact` or `vendor/bin/phpunit`.
