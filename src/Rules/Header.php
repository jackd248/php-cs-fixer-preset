<?php

declare(strict_types=1);

/*
 * This file is part of the "php-cs-fixer-preset" Composer package.
 *
 * (c) 2025 Konrad Michalik <hej@konradmichalik.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KonradMichalik\PhpCsFixerPreset\Rules;

use JsonException;
use KonradMichalik\PhpCsFixerPreset\Package\{Author, CopyrightRange, Type};
use KonradMichalik\PhpCsFixerPreset\Service\ComposerService;
use RuntimeException;
use Stringable;

use function is_array;
use function sprintf;

/**
 * Header.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-3.0-or-later
 */
final class Header implements Rule, Stringable
{
    /**
     * @param list<Author> $packageAuthors
     */
    public function __construct(
        public readonly string $packageName,
        public readonly Type $packageType,
        public readonly array $packageAuthors = [],
        public readonly ?CopyrightRange $copyrightRange = null,
    ) {}

    public function __toString(): string
    {
        return trim(<<<HEADER
This file is part of the "{$this->packageName}" {$this->packageType->value}.

{$this->generateCopyrightLines()}

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
HEADER
        );
    }

    /**
     * @param Author|list<Author> $packageAuthors
     */
    public static function create(
        string $packageName,
        Type $packageType,
        Author|array $packageAuthors = [],
        ?CopyrightRange $copyrightRange = null,
    ): self {
        if (!is_array($packageAuthors)) {
            $packageAuthors = [$packageAuthors];
        }

        return new self(
            $packageName,
            $packageType,
            $packageAuthors,
            $copyrightRange,
        );
    }

    /**
     * @param ?list<Author> $packageAuthors
     *
     * @throws RuntimeException
     * @throws JsonException
     */
    public static function fromComposer(
        string $composerJsonPath = './composer.json',
        ?CopyrightRange $copyrightRange = null,
        ?string $packageName = null,
        ?Type $packageType = null,
        ?array $packageAuthors = null,
    ): self {
        $data = ComposerService::readComposerJson($composerJsonPath);

        if (null === $packageType) {
            $packageType = ComposerService::extractPackageType($data);
        }

        if (null === $packageName) {
            $packageName = ComposerService::extractPackageName($data, $packageType);
        }

        if (null === $packageAuthors) {
            $packageAuthors = ComposerService::extractAuthors($data);
        }

        if (null === $copyrightRange) {
            $copyrightRange = ComposerService::extractCopyrightRange($data);
        }

        return new self(
            $packageName,
            $packageType,
            $packageAuthors,
            $copyrightRange,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function get(): array
    {
        return [
            'header_comment' => [
                'header' => $this->__toString(),
                'comment_type' => 'comment',
                'location' => 'after_declare_strict',
                'separate' => 'both',
            ],
        ];
    }

    private function generateCopyrightLines(): string
    {
        if ([] === $this->packageAuthors) {
            return '';
        }

        $lines = [];

        foreach ($this->packageAuthors as $author) {
            if (null === $this->copyrightRange) {
                $lines[] = sprintf('(c) %s', $author->__toString());
                continue;
            }
            $lines[] = sprintf('(c) %s %s', $this->copyrightRange, $author->__toString());
        }

        return implode(\PHP_EOL, $lines);
    }
}
