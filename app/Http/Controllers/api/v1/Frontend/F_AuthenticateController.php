<?php

namespace App\Http\Controllers\api\v1\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Frontend\Auth\F_CreateAccountRequest;
use App\Http\Requests\v1\Frontend\Auth\F_SendOtpCodeRequest;
use App\Http\Requests\v1\Frontend\Auth\F_VerifyOtpCodeRequest;
use App\Services\Frontend\Auth\F_CreateAccountService;
use App\Services\Frontend\Auth\F_SendOtpCodeService;
use App\Services\Frontend\Auth\F_VerifyOtpCodeService;

class F_AuthenticateController extends Controller
{
    /**
     * Create a new instance.
     *
     * @param F_SendOtpCodeService $sendOtpCode
     * @param F_VerifyOtpCodeService $verifyOtpCode
     * @param F_CreateAccountService $createAccount
     */
    public function __construct(
        private F_SendOtpCodeService   $sendOtpCode,
        private F_VerifyOtpCodeService $verifyOtpCode,
        private F_CreateAccountService $createAccount)
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function sendOtp(F_SendOtpCodeRequest $request)
    {
        return $this->sendOtpCode->send($request->validated());
    }

    /**
     * Display a listing of the resource.
     */
    public function verifyOtp(F_VerifyOtpCodeRequest $request)
    {
        return $this->verifyOtpCode->verify($request->validated());
    }

    /**
     * Display a listing of the resource.
     */
    public function createAccount(F_CreateAccountRequest $request)
    {
        return $this->createAccount->create($request->validated());
    }
}
