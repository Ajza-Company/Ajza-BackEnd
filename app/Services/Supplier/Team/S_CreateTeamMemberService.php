<?php

namespace App\Services\Supplier\Team;

use App\Enums\ErrorMessageEnum;
use App\Enums\SuccessMessagesEnum;
use App\Repositories\Supplier\Store\Find\S_FindStoreInterface;
use App\Repositories\Supplier\User\Create\S_CreateUserInterface;
use Illuminate\Http\JsonResponse;

class S_CreateTeamMemberService
{
    /**
     * Create a new instance.
     *
     * @param S_CreateUserInterface $createUser
     * @param S_FindStoreInterface $findStore
     */
    public function __construct(private S_CreateUserInterface $createUser, private S_FindStoreInterface $findStore)
    {
    }

    /**
     * Create a new offer.
     *
     * @param array $data
     * @return JsonResponse
     */
    public function create(array $data): JsonResponse
    {
        \DB::beginTransaction();
        try {
            $store = $this->findStore->find($data['store_id']);

            $user = $this->createUser->create([
                'company_id' => $store->company_id,
                ...$data['data']
            ]);

            $store->storeUsers()->create(['user_id' => $user->id]);

            $user->syncPermissions($data['permissions']);

            \DB::commit();
            return response()->json(successResponse(trans(SuccessMessagesEnum::CREATED)));
        } catch (\Exception $ex) {
            \DB::rollBack();
            return response()->json(errorResponse(trans(ErrorMessageEnum::CREATE), $ex->getMessage()), 500);
        }
    }
}
