<?php

namespace App\Http\Controllers\api\v1\Supplier;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Supplier\Auth\S_LoginRequest;
use App\Services\Supplier\Auth\S_LoginService;
use Illuminate\Http\Request;

class S_AuthController extends Controller
{
    /**
     * Create a new instance.
     *
     * @param S_LoginService $loginService
     */
    public function __construct(private S_LoginService $loginService)
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function login(S_LoginRequest $request)
    {
        return $this->loginService->login($request->validated());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
