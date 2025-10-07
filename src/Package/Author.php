<?php

declare(strict_types=1);

/*
 * This file is part of the "konradmichalik/php-cs-fixer-preset" Composer package.
 *
 * (c) 2025 Konrad Michalik <hej@konradmichalik.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KonradMichalik\PhpCsFixerPreset\Package;

use JsonException;
use RuntimeException;
use Stringable;

use function file_exists;
use function file_get_contents;
use function is_array;
use function json_decode;
use function sprintf;

/**
 * Author.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-3.0-or-later
 */
final class Author implements Stringable
{
    private function __construct(
        public readonly string $name,
        public readonly string $emailAddress,
    ) {}

    public function __toString(): string
    {
        return sprintf('%s <%s>', $this->name, $this->emailAddress);
    }

    public static function create(
        string $name,
        string $emailAddress,
    ): self {
        return new self($name, $emailAddress);
    }

    /**
     * @return list<self>
     *
     * @throws JsonException
     */
    public static function fromComposer(string $composerJsonPath = './composer.json'): array
    {
        if (!file_exists($composerJsonPath)) {
            throw new RuntimeException(sprintf('Composer file not found at: %s', $composerJsonPath));
        }

        $contents = file_get_contents($composerJsonPath);
        if (false === $contents) {
            throw new RuntimeException(sprintf('Failed to read composer file at: %s', $composerJsonPath));
        }

        $data = json_decode($contents, true, 512, \JSON_THROW_ON_ERROR);

        if (!isset($data['authors']) || !is_array($data['authors'])) {
            return [];
        }

        $authors = [];
        foreach ($data['authors'] as $authorData) {
            if (!is_array($authorData)) {
                continue;
            }

            $name = $authorData['name'] ?? null;
            $email = $authorData['email'] ?? null;

            if (null === $name || null === $email) {
                continue;
            }

            $authors[] = new self($name, $email);
        }

        return $authors;
    }
}
