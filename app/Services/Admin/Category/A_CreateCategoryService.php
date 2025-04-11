<?php

namespace App\Services\Admin\Category;

use App\Enums\RoleEnum;
use Illuminate\Http\Response;
use App\Models\Category;
use App\Models\CategoryLocale;
use App\Enums\ErrorMessageEnum;
use Illuminate\Http\JsonResponse;
use App\Enums\SuccessMessagesEnum;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\v1\Frontend\Category\F_CategoryResource;

class A_CreateCategoryService
{
    /**
     * Create a new instance.
     */
    public function __construct()
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

            $category = Category::create();

            foreach($data['localized'] as $local){
                $loc =CategoryLocale::create([
                    'locale_id'=>$local['local_id'],
                    'name'=>$local['name'],
                    'category_id'=>$category->id
                ]);
            }    

            \DB::commit();
            return response()->json(successResponse(message: trans(SuccessMessagesEnum::CREATED), data: F_CategoryResource::make($category)));
        } catch (\Exception $ex) {
            \DB::rollBack();
            return response()->json(errorResponse(
                message: trans(ErrorMessageEnum::CREATE),
                error: $ex->getMessage()),
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
