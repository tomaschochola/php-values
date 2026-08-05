<?php

/**
 * @author Tomáš Chochola <tomaschochola@tomaschochola.cz>
 * @copyright © 2026 Tomáš Chochola <tomaschochola@tomaschochola.cz>
 *
 * @license CC-BY-ND-4.0
 *
 * @see {@link https://creativecommons.org/licenses/by-nd/4.0/} License
 * @see {@link https://github.com/tomaschochola} GitHub Profile
 * @see {@link https://github.com/sponsors/tomaschochola} GitHub Sponsors
 */

declare(strict_types=1);

namespace Tests;

use ArrayIterator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\Attributes\Test;
use TomasChochola\Values\Iterables;

use function iterator_to_array;

/**
 * @internal
 *
 * @no-named-arguments
 */
#[CoversClass(Iterables::class)]
#[Small()]
final class IterablesTest extends TestCase
{
    #[Test()]
    public function concatPreservesValuesAndKeys(): void
    {
        $entries = [];

        foreach (Iterables::concat(['same' => 1], new ArrayIterator(['same' => 2])) as $key => $value) {
            $entries[] = [$key, $value];
        }

        self::assertSame([['same', 1], ['same', 2]], $entries);
    }

    #[Test()]
    public function iteratorPreservesValuesAndKeys(): void
    {
        /**
         * @var array<string, int> $empty
         */
        $empty = [];
        $iterator = Iterables::iterator(['first' => 1, 'second' => 2]);

        self::assertSame(['first' => 1, 'second' => 2], iterator_to_array($iterator));
        self::assertSame([], iterator_to_array(Iterables::iterator($empty)));
    }

    #[Test()]
    public function traversablePreservesValuesAndKeys(): void
    {
        /**
         * @var array<string, int> $empty
         */
        $empty = [];
        $traversable = Iterables::traversable(['first' => 1, 'second' => 2]);

        self::assertSame(['first' => 1, 'second' => 2], iterator_to_array($traversable));
        self::assertSame([], iterator_to_array(Iterables::traversable($empty)));
    }
}
