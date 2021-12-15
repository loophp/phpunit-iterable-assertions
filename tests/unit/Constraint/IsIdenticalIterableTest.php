<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace tests\loophp\PhpUnitIterableAssertions\Constraint;

use ArrayIterator;
use ArrayObject;
use IteratorAggregate;
use loophp\PhpUnitIterableAssertions\Constraint\IsIdenticalIterable;
use PHPUnit\Framework\TestCase;
use Traversable;

/**
 * @coversDefaultClass \loophp\PhpUnitIterableAssertions
 *
 * @internal
 */
final class IsIdenticalIterableTest extends TestCase
{
    public function dataProvider()
    {
        yield [
            range('a', 'c'),
            range('a', 'c'),
            range('c', 'a'),
        ];

        yield [
            [0 => 'a', 1 => 'b', 2 => 'c'],
            [0 => 'a', 1 => 'b', 2 => 'c'],
            range('c', 'a'),
        ];

        yield [
            new ArrayObject([0 => 'a', 1 => 'b', 2 => 'c']),
            new ArrayObject([0 => 'a', 1 => 'b', 2 => 'c']),
            range('c', 'a'),
        ];

        yield [
            new ArrayIterator([0 => 'a', 1 => 'b', 2 => 'c']),
            new ArrayIterator([0 => 'a', 1 => 'b', 2 => 'c']),
            range('c', 'a'),
        ];

        $iterator = new class implements IteratorAggregate
        {
            private iterable $iterable;

            public function withIterable(iterable $iterable): self
            {
                $clone = clone $this;
                $clone->iterable = $iterable;

                return $clone;
            }

            public function getIterator(): Traversable
            {
                yield from $this->iterable;
            }
        };

        yield [
            $iterator->withIterable(range('a', 'c')),
            $iterator->withIterable(range('a', 'c')),
            range('c', 'a')
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testEvaluation(
        iterable $iterable1,
        iterable $iterable2,
        iterable $iterable3
    ) {
        $constraint = new IsIdenticalIterable($iterable1);

        self::assertTrue($constraint->evaluate($iterable2, '', true));
        self::assertFalse($constraint->evaluate($iterable3, '', true));
    }
}
