<?php

namespace App\Http;

class Constants
{
    public const EXPIRED_SMS_CODE             = 10;
    public const MISMATCH_SMS_CODE            = 11;
    public const VOTED_BEFORE_CODE            = 12;
    public const EXPIRED_SMS_MESSAGE          = "The code incorrect";
    public const MISMATCH_SMS_MESSAGE         = "The code doesn't match";
    public const MISMATCH_PASSWORDS           = 'Passwords is not match';
    public const USER_UNATHORIZED_MESSAGE     = 'Unauthorized';
    public const USER_FORIDDEN_MESSAGE        = "Forbidden";
    public const USER_UNAUTHENTICATED_MESSAGE = "Unauthenticated";
    public const NOT_FOUND_MESSAGE            = "Not found";
    public const VOTED_BEFORE_MESSAGE         = "User voted before";
}
