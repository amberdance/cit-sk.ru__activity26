<?php

namespace App\Helpers;

class ValidationHelper
{
    public const BIRTHDAY_REGEXP = "/^(?:0[1-9]|[12]\d|3[01])([\\/.-])(?:0[1-9]|1[012])\\1(?:19|20)\\d\\d$/";
    public const PASSWORD_REGEXP = "/^(?=(.*[a-z]){3,})(?=(.*[A-Z]){2,})(?=(.*[0-9]){1,}).{8,}$/";
    public const PHONE_REGEXP    = "/^(\+7[\- ]?)?(\([9]{1}\d{2}\)?[\- ]?)?[\d\- ]{5,10}$/";

    /**
     * Removes any non digit symbols from phone number
     *
     * @param string $phone
     *
     * @return string
     */
    public static function replacePhoneNumber(string $phone): string
    {
        return preg_replace("/^(\+7)|[\D]/", "", $phone);
    }
}
