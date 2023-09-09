<?php declare(strict_types=1);

namespace Amir\StringCalculator;

use Exception;
use InvalidArgumentException;
use function PHPUnit\Framework\throwException;

final class StringCalculator
{
    const DEFAULT_SEPARATOR = ",";

    // TODO: allow the \n and , to be a custom delimeter
    public static function Add(string $numbers): int
    {
        if (strlen($numbers) == 0 ) {
            return 0;
        }

        if (str_starts_with($numbers, '//')) {
            $numbers = substr($numbers, 2);
            [$delimeter, $numbers] = explode("\n", $numbers);
            $delimeter = "$delimeter";
        } else {
            $delimeter = StringCalculator::DEFAULT_SEPARATOR;
            $numbers = str_replace("\n", $delimeter, $numbers);
        }

        StringCalculator::validate_format($numbers, $delimeter);

        StringCalculator::detect_negative_numbers($numbers, $delimeter);

        $array_of_numbers = explode($delimeter, $numbers);

        if ($array_of_numbers == false) {
            return (int) $numbers;
        }

        /* foreach ($array_of_numbers as $number) { */
        /*     if (intval($number) != $number) { */
        /*         throwException() */
        /*     } */
        /* } */

        return array_sum($array_of_numbers);
    }

    private static function validate_format(string $input, string $delimeter): void
    {
        if (str_ends_with($input, $delimeter)) {
            throw new InvalidArgumentException();
        }

    }

    private static function detect_negative_numbers(string $number_sequence, string $delimeter): void
    {
        $negative_numbers = array_filter(explode($delimeter, $number_sequence), function($number) {
            if ((int) $number < 0) {
                return true;
            }

            return false;
        });

        if (! empty($negative_numbers)) {
            throw new Exception("Negative number(s) not allowed: " . implode(', ', $negative_numbers));
        }
    }
}
