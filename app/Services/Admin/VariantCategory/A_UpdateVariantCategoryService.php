<?php

namespace App\Services\Admin\VariantCategory;

use Illuminate\Support\Arr;
use Illuminate\Http\Response;
use App\Enums\ErrorMessageEnum;
use App\Models\VariantCategory;
use Illuminate\Http\JsonResponse;
use App\Enums\SuccessMessagesEnum;
use App\Models\VariantCategoryLocale;
use App\Http\Resources\v1\Admin\Variant\A_ShortVariantResource;

class A_UpdateVariantCategoryService
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
    public function update(array $data,$variant): JsonResponse
    {
        \DB::beginTransaction();
        try {

            $variant->update(Arr::except($data, ['localized']));

            foreach ($data['localized'] as $local) {
                VariantCategoryLocale::updateOrCreate(
                    [
                        'variant_category_id' => $variant->id,
                        'locale_id' => $local['local_id'],
                    ],
                    [
                        'name' => $local['name'],
                    ]
                );
            }

            \DB::commit();
            return response()->json(successResponse(message: trans(SuccessMessagesEnum::UPDATED), data: A_ShortVariantResource::make($variant)));
        } catch (\Exception $ex) {
            \DB::rollBack();
            return response()->json(errorResponse(
                message: trans(ErrorMessageEnum::UPDATE),
                error: $ex->getMessage()),
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
