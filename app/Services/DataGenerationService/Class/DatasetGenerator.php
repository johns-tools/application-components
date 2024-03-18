<?php

namespace App\Services\DataGenerationService\Class;

class DatasetGenerator
{
    private static $colors = ['red', 'green', 'blue', 'yellow', 'purple'];
    private static $groupings = ['A', 'B', 'C', 'D'];

    /**
     * Generates a dataset containing a specified number of records.
     * Each record is an associative array with a first name, last name, color, grouping, and a random ID.
     * The `first_name` and `last_name` are randomly generated strings of characters.
     * The `color` is randomly selected from a predefined list of colors.
     * The `grouping` is randomly selected from a predefined list of groupings.
     * The `random_id` is a randomly generated string of alphanumeric characters.
     *
     * @param int $count The number of records to generate. Defaults to 200.
     * @return array An array of associative arrays, each representing a record.
     */
    public static function generateRecords($count = 200)
    {
        $records = [];
        for ($i = 0; $i < $count; $i++) {
            $records[] = [
                'first_name' => self::randomString(5),
                'last_name' => self::randomString(7),
                'color' => self::$colors[array_rand(self::$colors)],
                'grouping' => self::$groupings[array_rand(self::$groupings)],
                'random_id' => self::randomString(10, true)
            ];
        }
        return $records;
    }

    /**
     * Generates a random string of a specified length. The string can optionally include digits.
     *
     * This method creates a random string using a specified set of characters. By default, it uses
     * the English alphabet (both lowercase and uppercase letters). If the `$includeDigits` parameter
     * is set to true, digits (0-9) are also included in the set of possible characters.
     *
     * The method works by randomly selecting characters from the available set until the desired
     * length is reached. This approach ensures that each character in the resulting string has an
     * equal probability of being any of the specified characters.
     *
     * @param int $length The length of the random string to generate. Defaults to 10.
     * @param bool $includeDigits Whether to include digits in the string. Defaults to false.
     * @return string The generated random string.
     */
    private static function randomString($length = 10, $includeDigits = false)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if ($includeDigits) {
            $characters .= '0123456789';
        }
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
