<?php

namespace App\Http\Controllers\api\v1\Admin;

use App\Enums\RoleEnum;
use Illuminate\Http\Request;
use App\Enums\SuccessMessagesEnum;
use App\Http\Controllers\Controller;
use App\Services\Admin\RepSales\F_CreateRepSalesService;
use App\Http\Resources\v1\Admin\User\A_ShortUserResource;
use App\Http\Requests\v1\Admin\RepSales\F_CreateRepSalesRequest;
use App\Http\Requests\v1\Admin\RepSales\F_UpdateRepSalesRequest;
use App\Repositories\Admin\RepSales\Fetch\A_FetchRepSalesInterface;
use App\Repositories\Supplier\User\Find\S_FindUserInterface;
use App\Services\Admin\RepSales\F_UpdateRepSalesService;
use App\Services\Admin\RepSales\F_DeleteRepSalesService;

class F_RepSalesController extends Controller
{
    /**
     * Create a new instance.
     *
     * @param F_CreateRepSalesService $createAccount
     */
    public function __construct(
        private F_CreateRepSalesService $createRepSales,
        private A_FetchRepSalesInterface $fetchRepSales,
        private F_UpdateRepSalesService $updateRepSales,
        private F_DeleteRepSalesService $deleteRepSales,
        private S_FindUserInterface $findRepSales)
    {

    }
    
    public function index() {
        return A_ShortUserResource::collection(
            $this->fetchRepSales->fetch(isLocalized: false,withCount: ['orders'], role: RoleEnum::REPRESENTATIVE)
        );
    }

    public function store(F_CreateRepSalesRequest $request)
    {
        return $this->createRepSales->create($request->validated());
    }

    public function update(F_UpdateRepSalesRequest $request,string $id)
    {
        $repSales =  $this->findRepSales->find(decodeString($id));
        return $this->updateRepSales->update($request->validated(),$repSales);
    }

    public function delete(string $id)
    {
        $repSales =  $this->findRepSales->find(decodeString($id));
        return $this->deleteRepSales->delete($repSales);
    }

}
