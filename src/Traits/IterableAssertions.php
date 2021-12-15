<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\PhpUnitIterableAssertions\Traits;

use loophp\PhpUnitIterableAssertions\Constraint\IsIdenticalIterable;
use loophp\PhpUnitIterableAssertions\Constraint\IsNotIdenticalIterable;
use PHPUnit\Framework\TestCase;

/**
 * @mixin TestCase
 */
trait IterableAssertions
{
    public static function assertIdenticalIterable(iterable $expected, iterable $actual, string $message = ''): void
    {
        self::assertThat($actual, new IsIdenticalIterable($expected), $message);
    }

    public static function assertNotIdenticalIterable(iterable $expected, iterable $actual, string $message = ''): void
    {
        self::assertThat($actual, new IsNotIdenticalIterable($expected), $message);
    }
}
