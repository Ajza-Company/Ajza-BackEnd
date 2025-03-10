<?php

namespace App\Http\Controllers\api\v1\Admin;

use App\Enums\RoleEnum;
use Illuminate\Http\Request;
use App\Enums\SuccessMessagesEnum;
use App\Http\Controllers\Controller;
use App\Services\Admin\RepSales\F_CreateRepSalesService;
use App\Http\Resources\v1\Admin\User\A_ShortUserResource;
use App\Http\Requests\v1\Admin\RepSales\F_CreateRepSalesRequest;
use App\Repositories\Admin\RepSales\Fetch\A_FetchRepSalesInterface;

class F_RepSalesController extends Controller
{
    /**
     * Create a new instance.
     *
     * @param F_CreateRepSalesService $createAccount
     */
    public function __construct(
        private F_CreateRepSalesService $createRepSales,
        private A_FetchRepSalesInterface $fetchRepSales)
    {

    }
    
    public function index() {
        return A_ShortUserResource::collection(
            $this->fetchRepSales->fetch(isLocalized: false, role: RoleEnum::REPRESENTATIVE)
        );
    }

    /**
     * Display a listing of the resource.
     */
    public function store(F_CreateRepSalesRequest $request)
    {
        return $this->createRepSales->create($request->validated());
    }
}
