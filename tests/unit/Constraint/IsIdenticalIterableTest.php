<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace tests\loophp\PhpUnitIterableAssertions\Constraint;

use ArrayIterator;
use ArrayObject;
use loophp\iterators\ClosureIteratorAggregate;
use loophp\PhpUnitIterableAssertions\Constraint\IsIdenticalIterable;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \loophp\PhpUnitIterableAssertions
 *
 * @internal
 */
final class IsIdenticalIterableTest extends TestCase
{
    public static function provideEvaluationCases()
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

        yield [
            new ClosureIteratorAggregate(static fn () => yield from range('a', 'c')),
            new ClosureIteratorAggregate(static fn () => yield from range('a', 'c')),
            range('c', 'a'),
        ];
    }

    /**
     * @dataProvider provideEvaluationCases
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
