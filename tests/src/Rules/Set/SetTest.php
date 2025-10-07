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

namespace KonradMichalik\PhpCsFixerPreset\Tests\Rules\Set;

use KonradMichalik\PhpCsFixerPreset\Rules\{Rule, Set\Set};
use PHPUnit\Framework\TestCase;

/**
 * SetTest.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-3.0-or-later
 */
final class SetTest extends TestCase
{
    public function testImplementsRuleInterface(): void
    {
        $set = Set::create();

        self::assertInstanceOf(Rule::class, $set);
    }

    public function testCreateReturnsSetInstance(): void
    {
        $set = Set::create();

        self::assertInstanceOf(Set::class, $set);
    }

    public function testCreateReturnsEmptyRules(): void
    {
        $set = Set::create();

        self::assertSame([], $set->get());
    }

    public function testFromArrayReturnsSetInstance(): void
    {
        $rules = ['strict_types' => true];
        $set = Set::fromArray($rules);

        self::assertInstanceOf(Set::class, $set);
    }

    public function testFromArrayStoresRules(): void
    {
        $rules = [
            'strict_types' => true,
            'array_syntax' => ['syntax' => 'short'],
        ];

        $set = Set::fromArray($rules);

        self::assertSame($rules, $set->get());
    }

    public function testGetReturnsRules(): void
    {
        $rules = ['no_unused_imports' => true];
        $set = Set::fromArray($rules);

        self::assertSame($rules, $set->get());
    }

    public function testFromArrayWithEmptyArray(): void
    {
        $set = Set::fromArray([]);

        self::assertSame([], $set->get());
    }

    public function testFromArrayWithComplexRules(): void
    {
        $rules = [
            'header_comment' => [
                'header' => 'Test header',
                'comment_type' => 'comment',
            ],
            'ordered_imports' => [
                'imports_order' => ['class', 'function', 'const'],
            ],
            'blank_line_before_statement' => [
                'statements' => ['return'],
            ],
        ];

        $set = Set::fromArray($rules);

        self::assertSame($rules, $set->get());
    }

    public function testFromArrayWithBooleanValues(): void
    {
        $rules = [
            'strict_types' => true,
            'no_trailing_whitespace' => false,
            'single_quote' => true,
        ];

        $set = Set::fromArray($rules);

        self::assertSame($rules, $set->get());
        self::assertTrue($set->get()['strict_types']);
        self::assertFalse($set->get()['no_trailing_whitespace']);
    }

    public function testFromArrayPreservesArrayStructure(): void
    {
        $rules = [
            'level_1' => [
                'level_2' => [
                    'level_3' => 'value',
                ],
            ],
        ];

        $set = Set::fromArray($rules);

        self::assertSame($rules, $set->get());
        self::assertSame('value', $set->get()['level_1']['level_2']['level_3']);
    }
}
