<?php

namespace App\Services\Frontend\Order;

use App\Enums\ErrorMessageEnum;
use App\Enums\OrderStatusEnum;
use App\Enums\SuccessMessagesEnum;
use App\Models\Order;
use App\Models\Store;
use App\Models\StoreProduct;
use App\Models\User;
use App\Repositories\Frontend\Order\Create\F_CreateOrderInterface;
use App\Repositories\Frontend\OrderProduct\Insert\F_InsertOrderProductInterface;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class F_CreateOrderService
{
    /**
     *
     * @param F_CreateOrderInterface $createOrder
     * @param F_InsertOrderProductInterface $insertOrderProduct
     */
    public function __construct(private F_CreateOrderInterface $createOrder,
                                private F_InsertOrderProductInterface $insertOrderProduct)
    {

    }

    /**
     *
     * @param array $data
     * @param User $user
     * @param Store $store
     * @return JsonResponse
     */
    public function create(array $data, User $user, Store $store): JsonResponse
    {
        \DB::beginTransaction();
        try {

            $order = $this->createOrder->create([
                'user_id' => $user->id,
                'store_id' => $store->id,
                'status' => OrderStatusEnum::PENDING,
                'delivery_method' => $data['delivery_method'],
                'amount' => 0
            ]);

            $this->insertOrderProduct->insert($this->prepareOrderProductsBulkInsert($data['order_products'], $order));

            \DB::commit();
            return response()->json(successResponse(message: SuccessMessagesEnum::CREATED));
        } catch (\Exception $ex) {
            \DB::rollBack();
            return response()->json(errorResponse(
                message: ErrorMessageEnum::CREATE,
                error: $ex->getMessage()),
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     *
     * @param array $products
     * @param Order $order
     * @return array
     */
    function prepareOrderProductsBulkInsert(array $products, Order $order): array
    {
        $resultArr = [];


        foreach ($products as $product) {
            $storeProduct = StoreProduct::findOrFail($product['product_id']);
            $resultArr[] = [
                "order_id" => $order->id,
                'store_product_id' => $product['product_id'],
                "price" => $storeProduct->price,
                "quantity" => $product['quantity'],
                'discount' => 0,
                'amount' => $storeProduct->price * $product['quantity'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }

        return $resultArr;
    }
}
