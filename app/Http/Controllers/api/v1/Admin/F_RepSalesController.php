<?php

namespace App\Http\Controllers\api\v1\Admin;

use App\Enums\SuccessMessagesEnum;
use App\Http\Controllers\Controller;
use App\Services\Admin\RepSales\F_CreateRepSalesService;
use App\Http\Requests\v1\Admin\RepSales\F_CreateRepSalesRequest;

class F_RepSalesController extends Controller
{
    /**
     * Create a new instance.
     *
     * @param F_CreateRepSalesService $createAccount
     */
    public function __construct(
        private F_CreateRepSalesService $createRepSales)
    {

    }
    
    /**
     * Display a listing of the resource.
     */
    public function store(F_CreateRepSalesRequest $request)
    {
        return $this->createRepSales->create($request->validated());
    }
}
