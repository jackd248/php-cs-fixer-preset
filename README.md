<div align="center">

# # PHP-CS-Fixer Preset

[![Coverage](https://img.shields.io/coverallsCoverage/github/jackd248/php-cs-fixer-preset?logo=coveralls)](https://coveralls.io/github/jackd248/php-cs-fixer-preset)
[![CGL](https://img.shields.io/github/actions/workflow/status/jackd248/php-cs-fixer-preset/cgl.yml?label=cgl&logo=github)](https://github.com/jackd248/php-cs-fixer-preset/actions/workflows/cgl.yml)
[![Tests](https://img.shields.io/github/actions/workflow/status/jackd248/php-cs-fixer-preset/tests.yml?label=tests&logo=github)](https://github.com/jackd248/php-cs-fixer-preset/actions/workflows/tests.yml)
[![Supported PHP Versions](https://img.shields.io/packagist/dependency-v/konradmichalik/php-cs-fixer-preset/php?logo=php)](https://packagist.org/packages/konradmichalik/php-cs-fixer-preset)

</div>

This package provides a basic [PHP-CS-Fixer](https://github.com/PHP-CS-Fixer/PHP-CS-Fixer) configuration.

> [!IMPORTANT]
> TThis package is intended for use in my personal projects only. It is not designed for general use.


## 🔥 Installation

```bash
composer require konradmichalik/php-cs-fixer-preset
```

## ⚡ Usage

Configure PHP-CS-Fixer in your `.php-cs-fixer.php` file:

```php
use KonradMichalik\PhpCsFixerPreset\Config;
use KonradMichalik\PhpCsFixerPreset\Package\{Author, CopyrightRange, Type};
use KonradMichalik\PhpCsFixerPreset\Rules\Header;
use Symfony\Component\Finder\Finder;

return Config::create()
    ->withRule(
        Header::create(
            'konradmichalik/php-cs-fixer-preset',
            Type::ComposerPackage,
            Author::create('Konrad Michalik', 'hej@konradmichalik.dev'),
            CopyrightRange::from(2025),
        ),
    )
    ->withFinder(static fn (Finder $finder) => $finder->in(__DIR__))
;
```

## 💎 Credits

This project is highly inspired by the fabulous [php-cs-fixer-config](https://github.com/eliashaeussler/php-cs-fixer-config) package.

## ⭐ License

This project is licensed under [GNU General Public License 3.0 (or later)](LICENSE).
