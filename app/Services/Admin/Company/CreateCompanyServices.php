<?php

namespace App\Services\Admin\Company;

use App\Models\CompanyLocale;
use Illuminate\Http\Response;
use App\Enums\ErrorMessageEnum;
use Illuminate\Http\JsonResponse;
use App\Enums\SuccessMessagesEnum;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use App\Http\Resources\v1\User\UserResource;
use App\Events\v1\Frontend\F_UserCreatedEvent;
use App\Services\Supplier\Store\S_CreateStoreService;
use App\Repositories\Frontend\User\Create\F_CreateUserInterface;
use App\Repositories\Admin\Company\Create\F_CreateCompanyInterface;
use App\Repositories\Frontend\Wallet\Create\F_CreateWalletInterface;

class CreateCompanyServices
{
    /**
     * Create a new instance.
     *
     * @param F_CreateUserInterface $createUser
     */
    public function __construct(private F_CreateUserInterface $createUser,
                                private F_CreateCompanyInterface $createCompany,
                                private S_CreateStoreService $createStore)
    {

    }

    /**
     *
     * @param array $data
     *
     * @return JsonResponse
     */
    public function create(array $data): JsonResponse
    {
        \DB::beginTransaction();
        try {
            if (!isValidPhone($data['user']['full_mobile'])) {
                return response()->json(errorResponse(message: 'Invalid number detected! Let’s try a different one.'),Response::HTTP_BAD_REQUEST);
            }

            $user = $this->createUser($data['user']);

            $company = $this->createCompany($data['company'],$user);

            $data['store']['company_id'] = $company->id;
            $this->createStore->create($data['store']);

            \DB::commit();
            return response()->json(successResponse(message: trans(SuccessMessagesEnum::CREATED)));
        } catch (\Exception $ex) {
            \DB::rollBack();
            return response()->json(errorResponse(
                message: trans(ErrorMessageEnum::CREATE),
                error: $ex->getMessage()),
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function createUser($data) {
        $avatar = null;
        if (isset($data['avatar'])) {
            $avatar = uploadFile('user/avatar', $data['avatar']);
        }
    
        $user = $this->createUser->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'full_mobile' => $data['full_mobile'],
            'avatar' => $avatar,
            'is_registered' => true,
            'gender' => $data['gender'],
            'password' => Hash::make($data['password']),
            'preferred_language' => $data['preferred_language'] ?? app()->getLocale(),
        ]);
    
        $role = Role::where('name', 'Supplier')->first();
        $user->syncRoles([$role]);
    
        $permissions = Permission::pluck('name'); 
        $user->syncPermissions($permissions); 
    
        return $user;
    }
    
    private function createCompany($data , $user) {
        $logo = null;
        $coverImage = null;
        $commercialRegisterFile = null;
        if (isset($data['logo'])) {
            $logo = uploadFile('company/logo',$data['logo'],);
        }
        if (isset($data['cover_image'])) {
            $coverImage = uploadFile('company/cover_image',$data['cover_image'],);
        }
        if (isset($data['commercial_register_file'])) {
            $commercialRegisterFile = uploadFile('company/commercial_register_file',$data['commercial_register_file'],);
        }

        $company = $this->createCompany->create([
            'country_id'=>$data['country_id'],
            'user_id'=>$user->id,
            'email'=>$data['email'],
            'phone'=>$data['phone'],
            'logo'=>$logo,
            'cover_image'=>$coverImage,
            'commercial_register'=>$data['commercial_register'],
            'vat_number'=>$data['vat_number'],
            'commercial_register_file'=>$commercialRegisterFile,
        ]);

        foreach($data['localized'] as $local){
            CompanyLocale::create([
                'locale_id'=>$local['local_id'],
                'name'=>$local['name'],
                'company_id'=>$company->id
            ]);
        }
    return $company;
    }
}
