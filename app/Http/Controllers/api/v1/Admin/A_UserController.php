<?php

namespace App\Http\Controllers\api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\Admin\User\A_ShortUserResource;
use App\Repositories\Admin\User\Fetch\A_FetchUserInterface;
use Illuminate\Http\Request;

class A_UserController extends Controller
{
    /**
     *
     * @param A_FetchUserInterface $fetchUser
     */
    public function __construct(private A_FetchUserInterface $fetchUser)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return A_ShortUserResource::collection($this->fetchUser->fetch(isLocalized:false, withCount: ['orders']));
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
