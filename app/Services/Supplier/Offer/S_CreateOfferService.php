<?php

namespace App\Services\Supplier\Offer;

use App\Enums\ErrorMessageEnum;
use App\Enums\SuccessMessagesEnum;
use App\Models\Store;
use App\Repositories\Supplier\Offer\Insert\S_InsertOfferInterface;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class S_CreateOfferService
{
    /**
     * Create a new instance.
     *
     * @param S_InsertOfferInterface $insertOffer
     */
    public function __construct(private S_InsertOfferInterface $insertOffer)
    {
    }

    /**
     * Create a new offer.
     *
     * @param array $data
     * @param Store $store
     * @return JsonResponse
     */
    public function create(array $data, Store $store): JsonResponse
    {
        try {
            $products = $this->getProducts($data, $store);
            $offerData = $this->prepareStoreProductOfferBulkInsert($products, $data);

            $this->insertOffer->insert($offerData);

            return response()->json(successResponse(trans(SuccessMessagesEnum::CREATED)));
        } catch (\Exception $ex) {
            return response()->json(errorResponse(trans(ErrorMessageEnum::CREATE), $ex->getMessage()));
        }
    }

    /**
     * Get products based on data.
     *
     * @param array $data
     * @param Store $store
     * @return array
     */
    private function getProducts(array $data, Store $store): array
    {
        if ($data['product_id'] === null) {
            return $store->storeProducts->pluck('id')->toArray();
        }

        return [$data['product_id']];
    }

    /**
     * Prepare store product offer bulk insert data.
     *
     * @param array $products
     * @param array $data
     * @return array
     */
    private function prepareStoreProductOfferBulkInsert(array $products, array $data): array
    {
        $result = [];

        foreach ($products as $product) {
            $result[] = [
                'store_product_id' => $product,
                'type' => $data['type'],
                'discount' => $data['discount'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        return $result;
    }

    /**
     * Return a success response.
     *
     * @param string $message
     * @return JsonResponse
     */
    private function successResponse(string $message): JsonResponse
    {
        return response()->json(['message' => $message]);
    }

    /**
     * Return an error response.
     *
     * @param string $message
     * @param string $error
     * @return JsonResponse
     */
    private function errorResponse(string $message, string $error): JsonResponse
    {
        return response()->json(['message' => $message, 'error' => $error], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
