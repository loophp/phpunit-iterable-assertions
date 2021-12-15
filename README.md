[![Latest Stable Version][latest stable version]][1]
 [![GitHub stars][github stars]][1]
 [![Total Downloads][total downloads]][1]
 [![GitHub Workflow Status][github workflow status]][2]
 [![Scrutinizer code quality][code quality]][3]
 [![Type Coverage][type coverage]][4]
 [![Code Coverage][code coverage]][3]
 [![License][license]][1]
 [![Donate!][donate github]][5]

# PHPUnit Iterable Assertions

## Description

Provide new assertions for your tests using [PHPUnit][35].

## Features

* `assertIdenticalIterable`
* `assertNotIdenticalIterable`

## Installation

```composer require --dev loophp/phpunit-iterable-assertions```

## Usage

```php
<?php

namespace tests;

use loophp\PhpUnitIterableAssertions\Traits\IterableAssertions;
use PHPUnit\Framework\TestCase;

final class MyTest extends TestCase
{
    use IterableAssertions;

    $expected = range('a', 'c');
    $actual = ['a' => 'a', 'b' => 'b', 'c' => 'c'];

    // This will fail: The keys are different.
    self::assertIdenticalIterable(
        $expected,
        $actual
    );

    // This will succeed: Both iterables are different.
    self::assertNotIdenticalIterable(
        $expected,
        $actual
    );
}
```

## Documentation

## Code quality, tests, benchmarks

Every time changes are introduced into the library, [Github][2] runs the
tests.

The library has tests written with [PHPunit][35].
Feel free to check them out in the `tests` directory.

Before each commit, some inspections are executed with [GrumPHP][36]; run
`composer grumphp` to check manually.

The quality of the tests is tested with [Infection][37] a PHP Mutation testing
framework - run `composer infection` to try it.

Static analyzers are also controlling the code. [PHPStan][38] and
[PSalm][39] are enabled to their maximum level.

## Contributing

Feel free to contribute by sending Github pull requests. I'm quite responsive :-)

If you can't contribute to the code, you can also sponsor me on [Github][5] or
[Paypal][6].

## Changelog

See [CHANGELOG.md][43] for a changelog based on [git commits][44].

For more detailed changelogs, please check [the release changelogs][45].

[1]: https://packagist.org/packages/loophp/phpunit-iterable-assertions
[latest stable version]: https://img.shields.io/packagist/v/loophp/phpunit-iterable-assertions.svg?style=flat-square
[github stars]: https://img.shields.io/github/stars/loophp/phpunit-iterable-assertions.svg?style=flat-square
[total downloads]: https://img.shields.io/packagist/dt/loophp/phpunit-iterable-assertions.svg?style=flat-square
[github workflow status]: https://img.shields.io/github/workflow/status/loophp/phpunit-iterable-assertions/Unit%20tests?style=flat-square
[code quality]: https://img.shields.io/scrutinizer/quality/g/loophp/phpunit-iterable-assertions/main.svg?style=flat-square
[3]: https://scrutinizer-ci.com/g/loophp/phpunit-iterable-assertions/?branch=main
[type coverage]: https://img.shields.io/badge/dynamic/json?style=flat-square&color=color&label=Type%20coverage&query=message&url=https%3A%2F%2Fshepherd.dev%2Fgithub%2Floophp%2Fphpunit-iterable-assertions%2Fcoverage
[4]: https://shepherd.dev/github/loophp/phpunit-iterable-assertions
[code coverage]: https://img.shields.io/scrutinizer/coverage/g/loophp/phpunit-iterable-assertions/main.svg?style=flat-square
[license]: https://img.shields.io/packagist/l/loophp/phpunit-iterable-assertions.svg?style=flat-square
[donate github]: https://img.shields.io/badge/Sponsor-Github-brightgreen.svg?style=flat-square
[donate paypal]: https://img.shields.io/badge/Sponsor-Paypal-brightgreen.svg?style=flat-square
[33]: https://loophp-iterators.rtfd.io
[28]: https://loophp-iterators.readthedocs.io/en/stable/pages/api.html
[32]: https://loophp-iterators.readthedocs.io/en/stable/pages/usage.html
[34]: https://github.com/loophp/phpunit-iterable-assertions/issues
[2]: https://github.com/loophp/phpunit-iterable-assertions/actions
[35]: https://phpunit.de/
[36]: https://github.com/phpro/grumphp
[37]: https://github.com/infection/infection
[38]: https://github.com/phpstan/phpstan
[39]: https://github.com/vimeo/psalm
[5]: https://github.com/sponsors/drupol
[43]: https://github.com/loophp/phpunit-iterable-assertions/blob/main/CHANGELOG.md
[44]: https://github.com/loophp/phpunit-iterable-assertions/commits/main
[45]: https://github.com/loophp/phpunit-iterable-assertions/releases
