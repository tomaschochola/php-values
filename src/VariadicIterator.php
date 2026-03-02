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

use AppendIterator;
use Iterator;

/**
 * @template TKey
 * @template TValue
 *
 * @extends AppendIterator<TKey, TValue, Iterator<TKey, TValue>>
 *
 * @no-named-arguments
 */
class VariadicIterator extends AppendIterator
{
    /**
     * @param iterable<TKey, TValue> ...$iterables
     */
    public function __construct(iterable ...$iterables)
    {
        parent::__construct();

        foreach ($iterables as $iterable) {
            $this->append(IterableIterator::iterator($iterable));
        }
    }
}
