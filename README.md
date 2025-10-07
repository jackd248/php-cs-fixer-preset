<div align="center">

# PHP-CS-Fixer Preset

[![Coverage](https://img.shields.io/coverallsCoverage/github/jackd248/php-cs-fixer-preset?logo=coveralls)](https://coveralls.io/github/jackd248/php-cs-fixer-preset)
[![CGL](https://img.shields.io/github/actions/workflow/status/jackd248/php-cs-fixer-preset/cgl.yml?label=cgl&logo=github)](https://github.com/jackd248/php-cs-fixer-preset/actions/workflows/cgl.yml)
[![Tests](https://img.shields.io/github/actions/workflow/status/jackd248/php-cs-fixer-preset/tests.yml?label=tests&logo=github)](https://github.com/jackd248/php-cs-fixer-preset/actions/workflows/tests.yml)
[![Supported PHP Versions](https://img.shields.io/packagist/dependency-v/konradmichalik/php-cs-fixer-preset/php?logo=php)](https://packagist.org/packages/konradmichalik/php-cs-fixer-preset)

</div>

This package provides a basic [PHP-CS-Fixer](https://github.com/PHP-CS-Fixer/PHP-CS-Fixer) configuration.

> [!IMPORTANT]
> This package is intended for use in my personal projects only. It is not designed for general use.

## 🔥 Installation

```bash
composer require konradmichalik/php-cs-fixer-preset --dev
```

## ⚡ Usage

Configure PHP-CS-Fixer in your `.php-cs-fixer.php` file:

```php
use KonradMichalik\PhpCsFixerPreset\Config;
use KonradMichalik\PhpCsFixerPreset\Package\{Author, CopyrightRange, Type};
use KonradMichalik\PhpCsFixerPreset\Rules\Header;
use KonradMichalik\PhpCsFixerPreset\Rules\Set\Set;
use Symfony\Component\Finder\Finder;

return Config::create()
    // Header Comment Rule with manual data
    ->withRule(
        Header::create(
            'konradmichalik/php-cs-fixer-preset',
            Type::ComposerPackage,
            Author::create('Konrad Michalik', 'hej@konradmichalik.dev'),
            CopyrightRange::from(2025),
        ),
    )
    // Header Comment Rule with Composer Detection
    ->withRule(
        Header::fromComposer(
            __DIR__ . '/composer.json',
            copyrightRange: CopyrightRange::from(2025) // Optional overwrite specific composer information
        ),
    )
    // Custom Rule
    ->withRule(
        Set::fromArray([
            'modernize_types_casting' => true,
        ]),
    )
    ->withFinder(static fn (Finder $finder) => $finder->in(__DIR__))
;
```

## 💎 Credits

This project is highly inspired by the fabulous [php-cs-fixer-config](https://github.com/eliashaeussler/php-cs-fixer-config) package by [Elias Häußler](https://github.com/eliashaeussler).

## ⭐ License

This project is licensed under [GNU General Public License 3.0 (or later)](LICENSE).
