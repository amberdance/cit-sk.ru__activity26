<?php

namespace RegionalPolls\Utils;

final class CaseHelper
{

    /**
     * @param string $input
     *
     * @return string
     */
    public static function camelToSnakeCase(string $input): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $input));
    }

    /**
     * @param string $input
     * @param string $seprartor
     *
     * @return string
     */
    public static function snakeToCamelCase(string $input, string $seprartor = "_"): string
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace($seprartor, ' ', $input))));
    }

    /**
     * @param array $array
     *
     * @return array
     */
    public static function keysToCamelCase(array $array): array
    {
        self::transformKeys(['self', 'snakeToCamelCase'], $array);

        return $array;
    }

    /**
     * @param array $array
     *
     * @return array
     */
    public static function keysToSnakeCase(array $array): array
    {
        self::transformKeys(['self', 'camelToSnakeCase'], $array);

        return $array;
    }

    /**
     * @param mixed $callback
     * @param mixed $array
     *
     * @return void
     */
    private static function transformKeys($callback, &$array): void
    {
        foreach (array_keys($array) as $key) {

            $value = &$array[$key];
            unset($array[$key]);

            $transformedKey = call_user_func($callback, $key);

            if (is_array($value)) {
                self::transformKeys($callback, $value);
            }

            $array[$transformedKey] = $value;

            unset($value);
        }
    }

}
