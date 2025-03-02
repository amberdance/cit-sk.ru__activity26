<?php

namespace App\Helpers;

class ValidationHelper
{
    public const BIRTHDAY_REGEXP = "/^(?:0[1-9]|[12]\d|3[01])([\\/.-])(?:0[1-9]|1[012])\\1(?:19|20)\\d\\d$/";
    public const PASSWORD_REGEXP = "/^(?=(.*[a-z]){3,})(?=(.*[A-Z]){1,})(?=(.*[0-9]){1,}).{6,}$/";
    public const PHONE_REGEXP    = "/^(\+7|7|8)?(9){1}?[\d]{9}$/";
    public const CYRILIC_REGEXP  = "/^[а-яё]+$/iu";
    public const EMAIL_REGEXP    = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/";
    public const ADDRESS_REGEXP  = "/^[а-яё\d \\/\\-.,:\\\]+$/iu";

    /**
     * Removes any non digit symbols from phone number
     *
     * @param string $phone
     *
     * @return string
     */
    public static function replacePhoneNumber(string $phone): string
    {
        return preg_replace("/^(\+7|7|8)|[\D]/", "", $phone);
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public static function mbUcFirst(string $value): string
    {
        return mb_strtoupper(mb_substr($value, 0, 1, 'UTF-8'), 'UTF-8') . mb_substr($value, 1, mb_strlen($value, 'UTF-8'), 'UTF-8');
    }
}
