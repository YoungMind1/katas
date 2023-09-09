<?php declare(strict_types=1);

use Amir\StringCalculator\StringCalculator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertSame;

final class StringCalculatorTest extends TestCase
{
    public function testAddReturnsZeroForEmptyString(): void {
        $input = "";

        $output = StringCalculator::Add($input);

        assertSame(0, $output);
    }

    public function testAddReturnsTheNumberForStringWithOnlyOneNumber(): void
    {
        $input = "5";

        $output = StringCalculator::Add($input);

        assertSame(5, $output);
    }

    public function testAddReturnsTheSumForStringWithArbitraryAmountOfNumbersForDefaultDelimeters(): void
    {
        $numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
        $comma_separated_input = implode(',', $numbers);
        $new_line_separated_input = implode("\n", $numbers);
        $new_line_and_comma_separated_input = "1,2,3\n4\n5,6\n7,8\n9,10";

        $comma_separated_output = StringCalculator::Add($comma_separated_input);
        $new_line_separated_output = StringCalculator::Add($new_line_separated_input);
        $new_line_and_comma_separated_output = StringCalculator::Add($new_line_and_comma_separated_input);

        assertSame(55, $comma_separated_output);
        assertSame(55, $new_line_separated_output);
        assertSame(55, $new_line_and_comma_separated_output);
    }

    public function testAddThrowsExceptionIfStringEndsWithSeparator(): void
    {
        $input_ended_in_comma = "1,";

        $this->expectException(InvalidArgumentException::class);
        StringCalculator::Add($input_ended_in_comma);
    }

    #[DataProvider('provideDifferentDelimeters')]
    public function testAddForCustomDelimeters(string $input, int $expected): void
    {
        assertSame(StringCalculator::Add($input), $expected);
    }

    #[DataProvider('provideDifferentDelimetersWithEndingWithDelimeter')]
    public function testAddThrowsExceptionForCustomDelimetersEndingWithDelimeter(string $input): void
    {
        $this->expectException(InvalidArgumentException::class);
        StringCalculator::Add($input);
    }

    public function testAddThrowsExceptionForNegativeNumbers(): void
    {
        $default_delimeter = "1,2,3\n-5\n-1";

        $this->expectExceptionMessage("Negative number(s) not allowed: -5, -1");
        StringCalculator::Add($default_delimeter);

        $custom_delimeter = "\\hey%\n5hey%-1hey%-10hey%50";

        $this->expectExceptionMessage("Negative number(s) not allowed: -1, -10");
        StringCalculator::Add($default_delimeter);
    }

    /* public function testAddThrowsExceptionForInputWithDifferentDelimeterThanTheOneProvided(): void */
    /* { */
    /*     $error_prone_input = "//|\n1|2,3"; */
    /**/
    /*     $this->expectExceptionMessage("'|' expected but ',' found at position 3."); */
    /*     StringCalculator::Add($error_prone_input); */
    /* } */

    /**
     * @return array<string, array{string, int}>
     */
    public static function provideDifferentDelimeters(): array
    {
        return [
            'delimeter is %' => [
                "//%\n1%4%20", 25
            ],
            'delimeter is delimeter' => [
                "//delimeter\n1delimeter4delimeter25", 30
            ],
            'delimeter is ;' => [
                "//;\n1;3", 4
            ],
            'delimeter is |' => [
                "//|\n1|2|3", 6
            ],
            'delimeter is sep' => [
                "//sep\n2sep5", 7
            ]
        ];
    }

    /**
     * @return array<string, array{string}>
     */
    public static function provideDifferentDelimetersWithEndingWithDelimeter(): array
    {
        return [
            'delimeter is %' => [
                "//%\n1%4%20%"
            ],
            'delimeter is delimeter' => [
                "//delimeter\n1delimeter4delimeter25delimeter"
            ],
            'delimeter is ;' => [
                "//;\n1;3;"
            ],
            'delimeter is |' => [
                "//|\n1|2|3|"
            ],
            'delimeter is sep' => [
                "//sep\n2sep5sep"
            ]
        ];
    }
}
