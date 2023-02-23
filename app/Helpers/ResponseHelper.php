<?php


namespace App\Helpers;

class ResponseHelper
{
    const CODE_SUCCESS = 200;
    const CODE_PENDING = 99;
    const CODE_FAIL = 11;
    const CODE_SYSTEM_ERROR = 13;


    public function internalResponse($code, $message, $data = [])
    {
        if (empty($data)){
            $response = [
                'ResponseCode'    => $code,
                'ResponseMessage' => $message,
            ];
        } else {
            $response = [
                'ResponseCode'    => $code,
                'ResponseMessage' => $message,
                'ResponseData   ' => $data
            ];
        }

        return $response;
    }

    public static function getMessage($code)
    {
        $msgArr = [
            self::CODE_SUCCESS => 'Success',
            self::CODE_PENDING => 'Pending',
            self::CODE_FAIL    => 'Fail',
        ];
        return $msgArr[$code];
    }


}
