<?php

namespace App\Http\Controllers\api\v1\Admin;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Enums\SuccessMessagesEnum;
use App\Http\Controllers\Controller;
use App\Services\Frontend\F_WalletService;
use App\Services\Admin\User\A_CreateUserService;
use App\Http\Requests\v1\Admin\User\CreateUserRequest;
use App\Http\Requests\v1\Admin\User\A_DebitUserRequest;
use App\Http\Requests\v1\Admin\User\A_CreditUserRequest;
use App\Http\Resources\v1\Admin\User\A_ShortUserResource;
use App\Repositories\Admin\User\Fetch\A_FetchUserInterface;

class A_UserController extends Controller
{
    /**
     *
     * @param A_FetchUserInterface $fetchUser
     */
    public function __construct(private A_FetchUserInterface $fetchUser,
                                private F_WalletService $wallet,
                                private A_CreateUserService $createUser)
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
    public function store(CreateUserRequest $request)
    {
       return $this->createUser->create($request->validated());
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

    public function blockUser(User $user)  {
        $user->update([
            'is_active'=>!$user->is_active
        ]);
        return response()->json(successResponse(message: trans(SuccessMessagesEnum::UPDATED)));
    }

    public function credit(User $user ,A_CreditUserRequest $request) {
        $amount = $request['amount'];
        $description = $request['description'];
        $metadata = $request['metadata']??[];
        if(!$user->wallet){
            Wallet::create([
                'user_id' => $user->id
            ]);
        }
        return $this->wallet->credit($user->wallet ,$amount ,$description ,$metadata);
    }

    public function debit(User $user ,A_DebitUserRequest $request) {
        $amount = $request['amount'];
        $description = $request['description'];
        $metadata = $request['metadata']??[];
        if(!$user->wallet){
            Wallet::create([
                'user_id' => $user->id
            ]);
        }
        return $this->wallet->debit($user->wallet ,$amount ,$description ,$metadata);
    }

    // public function sendNotification(User $user , ) {

    // }
}
