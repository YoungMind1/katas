<?php declare(strict_types=1);

namespace Amir\FizzBuzz;

class FizzBuzz
{
    public static function fizzBuzz(int $number): string
    {
        if ($number % 3 == 0 && $number % 5 == 0) {
            return 'FizzBuzz';
        } else if ($number % 3 == 0) {
            return 'Fizz';
        } else if ($number % 5 == 0) {
            return 'Buzz';
        } 

        return (string) $number;
    }
} 
