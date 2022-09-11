<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\PhpUnitIterableAssertions\Constraint;

use Iterator;
use loophp\iterators\IterableIteratorAggregate;
use loophp\iterators\MultipleIterableAggregate;
use loophp\iterators\PackIterableAggregate;
use MultipleIterator;
use PHPUnit\Framework\Constraint\Constraint;

/**
 * @template TKey
 * @template T
 */
final class IsNotIdenticalIterable extends Constraint
{
    private int $limit;

    /**
     * @var iterable<TKey, T>
     */
    private iterable $subject;

    /**
     * @param iterable<TKey, T> $subject
     */
    public function __construct(iterable $subject, int $limit = 0)
    {
        $this->subject = $subject;
        $this->limit = $limit;
    }

    public function toString(): string
    {
        return 'has at least one different set of keys or values';
    }

    /**
     * @param iterable<TKey, T> $other
     */
    protected function matches($other): bool
    {
        [$subject, $other] = array_map(
            static fn (iterable $iterable): Iterator => (new IterableIteratorAggregate($iterable))->getIterator(),
            [$this->subject, $other]
        );

        $mi = new PackIterableAggregate(
            new MultipleIterableAggregate([$subject, $other], MultipleIterator::MIT_NEED_ALL)
        );

        foreach ($mi as $index => [$key, $value]) {
            if (0 !== $this->limit && $index >= $this->limit) {
                break;
            }

            if ($key[0] !== $key[1]) {
                return true;
            }

            if ($value[0] !== $value[1]) {
                return true;
            }
        }

        if (0 === $this->limit) {
            if ($subject->valid() !== $other->valid()) {
                return true;
            }
        }

        return false;
    }
}
