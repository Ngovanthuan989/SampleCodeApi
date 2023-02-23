<?php


namespace App\Business;


use App\Helpers\CommonHelper;
use App\Helpers\ResponseHelper;
use App\Repositories\CustomerRepository;
use App\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class CustomerBusiness
{
    private $customerRepo;
    private $responseHelper;
    public function __construct(CustomerRepository $customerRepository, ResponseHelper $responseHelper)
    {
        $this->customerRepo   = $customerRepository;
        $this->responseHelper = $responseHelper;
    }

    public function create($requestData)
    {
        $validate = $this->validateCreateCustomer($requestData);
        if ($validate['ResponseCode'] != ResponseHelper::CODE_SUCCESS) {
            return $validate;
        }

        $customerRepo = new CustomerRepository();
        $dataCustomer = [];
        $dataCustomer['email']   = $requestData->email;
        $dataCustomer['name']    = $requestData->name;
        $dataCustomer['phone']   = $requestData->phone;

        $createCustomer = $customerRepo->store($dataCustomer);

        if (!$createCustomer) {
            // DB::rollback();
            Log::info('Khong tao duoc customer');
            return $this->responseHelper->internalResponse(ResponseHelper::CODE_SYSTEM_ERROR, "Không tạo được Customer", []);
        }

        DB::commit();
        return $this->responseHelper->internalResponse(ResponseHelper::CODE_SUCCESS, ResponseHelper::getMessage(ResponseHelper::CODE_SUCCESS), $createCustomer);

    }

    public function validateCreateCustomer($requestData)
    {
        $validateBusiness = new ValidateBusiness();
        $validate = $validateBusiness->validateEmail($requestData->email);
        if ($validate['ResponseCode'] != ResponseHelper::CODE_SUCCESS) return $validate;

        $validate = $validateBusiness->validatePhone($requestData->phone);
        if ($validate['ResponseCode'] != ResponseHelper::CODE_SUCCESS) return $validate;

        $validate = $validateBusiness->validateFullname($requestData->name);
        if ($validate['ResponseCode'] != ResponseHelper::CODE_SUCCESS) return $validate;

        return $this->responseHelper->internalResponse($this->responseHelper::CODE_SUCCESS, $this->responseHelper::getMessage(200));
    }
}
