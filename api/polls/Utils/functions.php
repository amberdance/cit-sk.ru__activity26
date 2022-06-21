<?php

/**
 * @param mixed $a
 * @param mixed $b
 *
 * @return bool
 */
function isEqual($a, $b): bool
{

    return (
        is_string($a)
        && is_string($b)
        && $a == $b
        ||
        is_array($a)
        && is_array($b)
        && count($a) == count($b)
        && array_diff($a, $b) === array_diff($b, $a)
    );
}

/**
 * @param string $value
 *
 * @return string
 */
function toSingular(string $value): string
{

    $result = $value;

    if ($value[strlen($value) - 1] == "s") {
        $result = substr($value, 0, -1);
    }

    return $result;
}

/**
 * @param string $guid
 *
 * @return boo
 */
function isGUID(string $guid): bool
{
    return (bool) preg_match("/^(\{)?[a-f\d]{8}(-[a-f\d]{4}){4}[a-f\d]{8}(?(1)\})$/i", $guid);

}

/**
 * @param bool $includeBraces
 *
 * @return string
 */
function createGUID(bool $includeBraces = false): string
{
    if (function_exists('com_create_guid')) {

        if ($includeBraces === true) {

            return com_create_guid();
        } else {
            return substr(com_create_guid(), 1, 36);
        }
    } else {
        mt_srand((float) microtime() * 10000);

        $charid = md5(uniqid(rand(), true));
        $id     = substr($charid, 0, 8) . '-' .

        substr($charid, 8, 4) . '-' .
        substr($charid, 12, 4) . '-' .
        substr($charid, 16, 4) . '-' .
        substr($charid, 20, 12);

        if ($includeBraces) {
            $id = '{' . $id . '}';
        }

        return $id;
    }
}

/**
 * @param int $length
 *
 * @return string
 */
function getHashString(int $length = 32): string
{

    $length = ($length < 4) ? 4 : $length;

    return bin2hex(random_bytes(($length - ($length % 2)) / 2));
}

/**
 * @return string
 */
function getMysqlTimeStamp(): string
{
    return date('Y-m-d H:i:s');
}

/**
 * @param string|null $date
 * @param mixed string
 *
 * @return string
 */
function formatDate(string $date = null, string $format = 'd.m.Y H:i:s'): string
{

    if (!$date) {
        return "";
    }

    return date($format, strtotime($date));
}

/**
 * @param string $password
 *
 * @return string
 */
function passwordHash(string $password): string
{

    return password_hash(htmlspecialchars($password), PASSWORD_DEFAULT);

}
