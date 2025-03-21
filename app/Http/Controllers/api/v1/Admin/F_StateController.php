<?php

namespace App\Http\Controllers\api\v1\Admin;

use App\Enums\RoleEnum;
use Illuminate\Http\Request;
use App\Enums\SuccessMessagesEnum;
use App\Http\Controllers\Controller;
use App\Services\Admin\State\F_CreateStateService;
use App\Http\Resources\v1\Admin\State\A_ShortStateResource;
use App\Http\Requests\v1\Admin\State\F_CreateStateRequest;
use App\Http\Requests\v1\Admin\State\F_UpdateStateRequest;
use App\Repositories\Admin\State\Fetch\A_FetchStateInterface;
use App\Repositories\Admin\State\Find\S_FindStateInterface;
use App\Services\Admin\State\F_UpdateStateService;
use App\Services\Admin\State\F_DeleteStateService;

class F_StateController extends Controller
{
    /**
     * Create a new instance.
     *
     * @param F_CreateStateService $createAccount
     */
    public function __construct(
        private F_CreateStateService $createState,
        private A_FetchStateInterface $fetchState,
        private F_UpdateStateService $updateState,
        private F_DeleteStateService $deleteState,
        private S_FindStateInterface $findState)
    {

    }
    
    public function index() {
        return A_ShortStateResource::collection(
            $this->fetchState->fetch()
        );
    }

    public function store(F_CreateStateRequest $request)
    {
        return $this->createState->create($request->validated());
    }

    public function update(F_UpdateStateRequest $request,string $id)
    {
        $state =  $this->findState->find(decodeString($id));
        return $this->updateState->update($request->validated(),$state);
    }

    public function destroy(string $id)
    {
        $state =  $this->findState->find(decodeString($id));
        return $this->deleteState->delete($state);
    }

}
