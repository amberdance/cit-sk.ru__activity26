<?php

namespace App\Models;

use App\Constants;
use App\Exceptions\PhoneVerifyException;
use Error;
use Illuminate\Database\Eloquent\Model;

/**
 *  @property int $id
 *  @property int $userId
 *  @property int $verifyCode
 *  @property int $errorCode
 *  @property int $messageId
 *  @property int $attempts
 *  @property string $type
 *  @property string $created_at
 *  @property string $updated_at
 */

class SmsApi extends Model
{
    protected $table   = 'sms_codes';
    protected $guarded = [];

    /**
     * @param string $phoneNumber
     * @param int $verifyCode
     *
     * @return array
     */
    public static function makeIncomeCall(string $phoneNumber, int $verifyCode): array
    {

        $curl   = curl_init();
        $params = [
            "format" => "json",
            "method" => "push_msg",
            "route"  => "pc",
            "key"    => $_ENV['SMS_API_KEY'],
            "phone"  => $phoneNumber,
            "text"   => $verifyCode,
        ];

        curl_setopt($curl, CURLOPT_URL, "http://api.sms-prosto.ru/");
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $result = json_decode(curl_exec($curl), true);

        if ($result['response']['msg']['err_code'] != 0) {
            throw new PhoneVerifyException(Constants::FAILED_SEND_SMS_MESSAGE . " " . $phoneNumber, Constants::FAILED_SEND_SMS_CODE);
        }

        curl_close($curl);

        return $result['response'] ?? [];
    }
}
