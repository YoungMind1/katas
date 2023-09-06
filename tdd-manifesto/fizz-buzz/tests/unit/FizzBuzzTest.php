<?php declare(strict_types=1);

use Amir\FizzBuzz\FizzBuzz;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertSame;

final class FizzBuzzTest extends TestCase
{
    public function testFizzBuzzShouldReturnTheIntInputAsStringWhenItIsNotAMultipleOfThreeOrFive(): void
    {
        $int_input = 562;

        $output = FizzBuzz::fizzBuzz($int_input);

        assertSame((string) $int_input, $output);
    }

    public function testFizzBuzzShouldReturnStringFizzWhenGivenAMultipleOfThree(): void
    {
        $input = 3;

        $output = FizzBuzz::fizzBuzz($input);

        assertSame('Fizz', $output);
    }

    public function testFizzBuzzShouldReturnStringBuzzWhenGivenAMultipleOfFive(): void
    {
        $input = 5;

        $output = FizzBuzz::fizzBuzz($input);

        assertSame('Buzz', $output);
    }

    public function testFizzBuzzShouldReturnStringFizzBuzzWhenGivenAMultipleOfThreeAndFive(): void
    {
        $input = 15;

        $output = FizzBuzz::fizzBuzz($input);

        assertSame('FizzBuzz', $output);
    }
}
