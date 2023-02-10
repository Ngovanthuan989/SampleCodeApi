<?php

namespace App\Http\Controllers\Api;

use App\Business\CustomerBusiness;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    private $customerBusiness;
    public function __construct(CustomerBusiness $customerBusiness)
    {
        $this->customerBusiness = $customerBusiness;
    }

    public function create(Request $request){
        $requestData = json_decode($request->getContent());
        $response = $this->customerBusiness->create($requestData);
        $httpStatusCode = 200;
        if ($response['ResponseCode'] != 200){
            $httpStatusCode = 500;
        }
        return response($response, $httpStatusCode);
    }

}

