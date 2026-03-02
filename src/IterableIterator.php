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
use Iterator;
use IteratorAggregate;
use IteratorIterator;
use NoDiscard;
use Traversable;

use function is_array;

/**
 * @template TKey
 * @template TValue
 *
 * @extends IteratorIterator<TKey, TValue, Iterator<TKey, TValue>>
 *
 * @no-named-arguments
 */
class IterableIterator extends IteratorIterator
{
    /**
     * @param iterable<TKey, TValue> $iterable
     */
    public function __construct(iterable $iterable)
    {
        parent::__construct(static::iterator($iterable));
    }

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
            $iterator = $iterable->getIterator();

            if ($iterator instanceof Iterator) {
                return $iterator;
            }

            /** @phpstan-ignore-next-line return.type */
            return new IteratorIterator($iterator);
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
}
