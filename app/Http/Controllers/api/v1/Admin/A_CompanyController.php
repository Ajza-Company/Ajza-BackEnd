<?php

namespace App\Http\Controllers\api\v1\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\Company\CreateCompanyServices;
use App\Http\Requests\v1\Admin\Company\A_CreateCompanyRequest;
use App\Http\Resources\v1\Admin\Company\A_ShortCompanyResource;
use App\Repositories\Admin\Company\Fetch\A_FetchCompanyInterface;

class A_CompanyController extends Controller
{
    /**
     *
     * @param A_FetchCompanyInterface $fetchCompany
     */
    public function __construct(private A_FetchCompanyInterface $fetchCompany,
                                private CreateCompanyServices $createCompany)
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return A_ShortCompanyResource::collection($this->fetchCompany->fetch(withCount: ['stores', 'usersPivot'], with: ['user']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(A_CreateCompanyRequest $request)
    {
        $data = $request->validated();
        return $this->createCompany->create($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
