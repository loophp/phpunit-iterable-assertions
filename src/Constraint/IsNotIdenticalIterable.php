<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\PhpUnitIterableAssertions\Constraint;

use loophp\iterators\IterableIterator;
use MultipleIterator;
use PHPUnit\Framework\Constraint\Constraint;

final class IsNotIdenticalIterable extends Constraint
{
    private int $limit;

    private iterable $subject;

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
     * @param iterable $other
     */
    protected function matches($other): bool
    {
        $i1 = new IterableIterator($this->subject);
        $i2 = new IterableIterator($other);

        $mi = new MultipleIterator(MultipleIterator::MIT_NEED_ALL);
        $mi->attachIterator($i1);
        $mi->attachIterator($i2);

        $index = 0;

        foreach ($mi as $key => $value) {
            if (0 !== $this->limit && $index >= $this->limit) {
                break;
            }

            if ($key[0] !== $key[1]) {
                return true;
            }

            if ($value[0] !== $value[1]) {
                return true;
            }

            ++$index;
        }

        if (0 === $this->limit) {
            if ($i1->valid() !== $i2->valid()) {
                return true;
            }
        }

        return false;
    }
}
