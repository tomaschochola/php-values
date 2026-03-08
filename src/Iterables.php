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

namespace TomasChochola\Splx;

use ArrayIterator;
use Generator;
use Iterator;
use IteratorAggregate;
use IteratorIterator;
use NoDiscard;
use Traversable;

use function is_array;

/**
 * @no-named-arguments
 */
final class Iterables
{
    /**
     * @template TK
     * @template TV
     *
     * @param iterable<TK, TV> $iterable
     *
     * @return Iterator<TK, TV>
     */
    #[NoDiscard]
    public static function iterator(iterable $iterable): Iterator
    {
        if ($iterable instanceof Iterator) {
            return $iterable;
        }

        if ($iterable instanceof IteratorAggregate) {
            return static::iterator($iterable->getIterator());
        }

        if (is_array($iterable)) {
            /** @phpstan-ignore-next-line return.type */
            return new ArrayIterator($iterable);
        }

        return new IteratorIterator($iterable);
    }

    /**
     * @template TK
     * @template TV
     *
     * @param iterable<TK, TV> $iterable
     *
     * @return Traversable<TK, TV>
     */
    #[NoDiscard]
    public static function traversable(iterable $iterable): Traversable
    {
        if ($iterable instanceof Traversable) {
            return $iterable;
        }

        /** @phpstan-ignore-next-line return.type */
        return new ArrayIterator($iterable);
    }

    /**
     * @template TK
     * @template TV
     *
     * @param iterable<TK, TV> ...$iterables
     *
     * @return Generator<TK, TV>
     */
    #[NoDiscard]
    public static function concat(iterable ...$iterables): Generator
    {
        foreach ($iterables as $iterable) {
            yield from $iterable;
        }
    }
}
