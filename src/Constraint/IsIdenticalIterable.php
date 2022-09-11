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
final class IsIdenticalIterable extends Constraint
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
        return 'has exactly the same keys and values';
    }

    protected function additionalFailureDescription($other): string
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
                return sprintf('Expected iterable key is different from subject key at index %s', $index);
            }

            if ($value[0] !== $value[1]) {
                return sprintf('Expected iterable value is different from subject value at index %s', $index);
            }
        }

        $subjectValid = $subject->valid();
        $otherValid = $other->valid();

        if ($subjectValid !== $otherValid) {
            if (true === $subjectValid) {
                return 'Expected iterable has more items than subject.';
            }

            return 'Expected iterable has lesser items than subject.';
        }

        return '';
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
                return false;
            }

            if ($value[0] !== $value[1]) {
                return false;
            }
        }

        if (0 === $this->limit) {
            if ($subject->valid() !== $other->valid()) {
                return false;
            }
        }

        return true;
    }
}
