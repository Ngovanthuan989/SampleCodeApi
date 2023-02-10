<?php


namespace App\Business;


use App\Helpers\CommonHelper;
use App\Helpers\ResponseHelper;
use App\Repositories\CustomerRepository;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class ValidateBusiness
{

    // validate email
    public function validateEmail($email)
    {
        $responseHelper = new ResponseHelper();
        if (empty($email)) {
            Log::info('Message: Khong gui Email');
            $response = $responseHelper->internalResponse($responseHelper::CODE_FAIL, 'Khong gui email');
            goto end;
        }
        $regex = '/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/';

        if (!preg_match($regex, $email)) {
            Log::info('Message: Email khong dung dinh dang');
            $response = $responseHelper->internalResponse($responseHelper::CODE_FAIL, 'Email khong dung dinh dang');
            goto end;
        }

        if (CommonHelper::hasSpace($email)) {
            Log::info('Message: Email chua ky tu space');
            $response = $responseHelper->internalResponse($responseHelper::CODE_FAIL, 'Email chua ky tu space');
            goto end;
        }

        if (CommonHelper::hasVietnamese($email)) {
            Log::info('Message: Email chua ky tu tieng viet');
            $response = $responseHelper->internalResponse($responseHelper::CODE_FAIL, 'Email chua ky tu tieng viet');
            goto end;
        }

        $existedEmail = Customer::where('email', $email)->first();
        if ($existedEmail) {
            Log::info('Message: Email da ton tai trong he thong');
            $response = $responseHelper->internalResponse($responseHelper::CODE_FAIL, 'Email đã tồn tại');
            goto end;
        }
        $response = $responseHelper->internalResponse($responseHelper::CODE_SUCCESS, 'Validate email thanh cong');

        end:
        return $response;
    }

    // validate name

    public function validateFullname($fullname)
    {
        $responseHelper = new ResponseHelper();

        if (empty($fullname)) {
            Log::info('Message: Khong gui ten');
            $response = $responseHelper->internalResponse($responseHelper::CODE_FAIL, 'Khong gui ten');
            goto end;
        }

        if (CommonHelper::checkSpecialCharacter($fullname)) {
            Log::info('Message: Ten chua ki tu dac biet');
            $response = $responseHelper->internalResponse($responseHelper::CODE_FAIL, 'Ten chua ki tu dac biet');
            goto end;
        }

        if (strlen($fullname) < 2 || strlen($fullname) > 255) {
            Log::info('Message: Ten qua dai hoac qua ngan');
            $response = $responseHelper->internalResponse($responseHelper::CODE_FAIL, 'Ten qua dai hoac qua ngan');
            goto end;
        }

        $response = $responseHelper->internalResponse($responseHelper::CODE_SUCCESS, 'Validate fullname thanh cong');

        end:
        return $response;
    }

    // validate phone
    public function validatePhone($phone, $customerId = null)
    {
        $responseHelper = new ResponseHelper();

        if (empty($phone)) {
            Log::info('Message: Khong gui Phone');
            $response = $responseHelper->internalResponse($responseHelper::CODE_FAIL, 'Khong gui Phone');
            goto end;
        }

        if (!CommonHelper::checkIsDigit($phone)) {
            Log::info('Message: Phone chua ki tu khong phai so');
            $response = $responseHelper->internalResponse($responseHelper::CODE_FAIL, 'Phone chua ki tu khong phai so');
            goto end;
        }

        if (strlen($phone) != 10) {
            Log::info('Message: Phone khong co dung 10 ky tu');
            $response = $responseHelper->internalResponse($responseHelper::CODE_FAIL, 'Phone khong co dung 10 ky tu');
            goto end;
        }

        $regex = "/^(0[9|3|7|8|5]|84[9|3|7|8|5])([0-9]{8})$/";

        if (!preg_match($regex, $phone)) {
            Log::info('Message: Phone khong dung dinh dang');
            $response = $responseHelper->internalResponse($responseHelper::CODE_FAIL, 'Phone khong dung dinh dang');
            goto end;
        }

        if (isset($customerId)) {
            $existPhone = Customer::where('phone',$phone)->where('id','<>',$customerId)->first();
        } else {
            $existPhone = Customer::where('phone',$phone)->first();
        }

        if ($existPhone) {
            Log::info('Message: Phone da ton tai');
            $response = $responseHelper->internalResponse($responseHelper::CODE_FAIL, 'Phone đã tồn tại trong hệ thống');
            goto end;
        }



        $response = $responseHelper->internalResponse($responseHelper::CODE_SUCCESS, 'Validate phone thanh cong');

        end:
        return $response;
    }
}
