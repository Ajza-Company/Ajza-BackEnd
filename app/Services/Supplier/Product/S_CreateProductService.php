<?php

namespace App\Services\Supplier\Product;

use App\Models\Product;
use App\Models\StoreProduct;
use Illuminate\Http\Response;
use App\Enums\ErrorMessageEnum;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class S_CreateProductService
{
    /**
     *
     * @param array $data
     * @return JsonResponse
     */
    public function create(array $data): JsonResponse
    {
        try {
            DB::beginTransaction();
    
            if ($data['is_select_all'] == true) {
                $data['product_ids'] = Product::where('category_id', $data['category_id'])->pluck('id')->toArray();
            }
    
            Product::whereIn('id', $data['product_ids'])->chunk(100, function ($products) use ($data) {
                foreach ($products as $product) {
                    StoreProduct::updateOrCreate(
                        [
                            'store_id' => $data['store_id'],
                            'product_id' => $product->id
                        ], // Search for an existing record
                        [
                            'price' => $product->price,
                            'updated_at' => now()
                        ] // Update these values if found, otherwise insert
                    );
                }
            });
    
            DB::commit();
    
            return response()->json(successResponse(message: "Products synced successfully"));
        } catch (\Exception $ex) {
            DB::rollBack();
    
            return response()->json(errorResponse(
                message: ErrorMessageEnum::CREATE,
                error: $ex->getMessage()),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
    
}
